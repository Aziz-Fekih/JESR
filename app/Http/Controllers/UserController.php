<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Don;
use App\User;
use App\Adresse;
use Exception;
class UserController extends Controller
{
    public function getUsers(Request $request){
        $users = null;
        if($request->role){
            $users = User::where('role', intval($request->role))->get()->load('adresse');
        }else if($request->except){
            $users = User::where('role', '!=' , intval($request->except))->get()->load('adresse');
        }
        else{
            $users = User::all()->load('adresse');
        }
        return response()->json($users, 200);
    }
    public function getActeurs(Request $request){
            $users = null;
            $users = User::where('role', 1)->orWhere('role', 2)->get()->load('adresse');

        return response()->json($users, 200);
    }
    public function getUser(Request $request, User $user){
        if($user->id)
            return response()->json($user->load('adresse'), 200);
        return response()->json('User non trouve!', 400);  
    }


    public function updateUser(Request $request, User $user){
        // $role = 0;
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
        try{
            if($user->id){
                $user->update([ 'name' => $request->name,
                'lastname' => $request->lastname,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'gouvernorat' => $request->gouvernorat,
                'role' => $request->role,
                        ]);
                $adresse = Adresse::where('id', $user->adresse_id)->first();
                $adresse->update([  'adresse' => $request->adresse['adresse'],
                                    'gouvernorat' => $request->gouvernorat,
                                    'gouvernorat_id' => 1,
                        ]);
                return response()->json('User modifié!', 200);     
            }else{
                return response()->json('User non trouve!', 400); 
            }
        }catch(Exception $e){
            return response()->json($e->getMessage(), $e->getHttpStatus());
        }

    }

    public function deleteUser(Request $request, User $user){
        if($user->id){
            $user->delete();
            return response()->json('User supprime!', 200);  
        }
        return response()->json('User non trouve!', 400);  
    }

    public function getDons(Request $request, User $user){
        if($user->id){
            $dons = Don::where('user_id', $user->id)->get()->load('adresse', 'user');;
            return response()->json($dons, 200);  
        }
        return response()->json('User non trouve!', 400);  
    }
}