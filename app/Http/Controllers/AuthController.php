<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Adresse;
use App\Gouvernorat;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $email = $request->username;
        $password = $request->password;
        $secret = DB::table('oauth_clients')
            ->where('id', config('services.passport.client_id'))
            ->first()->secret;
        Log::info($secret);
        $request->request->add([
            'username' => $email,
            'password' => $password,
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => $secret
        ]);

        Log::info($email);

        $tokenRequest = Request::create(
            config('services.passport.login_endpoint'),
            'post'
        );
        Log::info($email);
        $response = Route::dispatch($tokenRequest);
        Log::info($email);

        if ($response->getStatusCode() == 200) {
            return $response;
        } else {
            return response()->json('Invalid Request. Please enter a username or a password.', $response->getStatusCode());
        }

        return $response;
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);
        Log::info('hello');
        try {
            $adresse = new Adresse();
            $adresse->adresse = $request->adresse['adresse'];
            $adresse->gouvernorat = $request->gouvernorat;
            $adresse->gouvernorat_id = 1; //Gouvernorat::where('nom', $request->gouvernorat)->first()->id;
            $adresse->save();
            $role = 0;
            // if($request->role){
            //     if($request->role == 'Teleoperateur'){
            //         $role = 0;
            //     }
            //     if($request->role == 'UTSS'){
            //         $role = 1;
            //     }
            //     if($request->role == 'CRRC'){
            //         $role = 2;
            //     }
            //     if($request->role == 'Admin_Ministere'){
            //         $role = 3;
            //     }
            // }
            return User::create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'telephone' => $request->telephone,
                'adresse_id' => $adresse->id,
                'email' => $request->email,
                'gouvernorat' => $request->gouvernorat,
                'password' => Hash::make($request->password),
                'role' => $request->role
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), $e->getHttpStatus());
        }
        return response()->json('Requete invalide', 400);
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }

}
