<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Association;
use App\Adresse;

use App\Gouvernorat;
class AssociationController extends Controller
{   
    public function createAssociation(request $request){

        $adresse = new Adresse();
        $adresse->adresse = $request->adresse['adresse'];
        $adresse->gouvernorat = $request->adresse['gouvernorat'];
        $adresse->gouvernorat_id = 1; //Gouvernorat::where('nom', $request->gouvernorat)->first()->id;
        $adresse->save();

        $association = new Association();
        $association->nom = $request->nom;
        $association->telephone = $request->telephone;
        $association->adresse_id = $adresse->id;
        $association->save();
        return response()->json('association ajoutee!', 200);  
        
    }
    public function getAssociations(request $request){
        $associations = Association::all()->load('adresse');
        return response()->json($associations, 200);
    }

    public function getAssociation(Request $request, Association $association){
        if($association->id)
            return response()->json($association->load('adresse'), 200);
        return response()->json('Association non trouvee!', 400);  
    }

    public function updateAssociation(Request $request, Association $association){
        
        if($association->id){
            $association->Update([  'nom' => $request->nom, 'telephone' => $request->telephone
                             ]);
            $adresse = Adresse::where('id', $association->adresse_id)->first();
            $adresse->Update([  'adresse' => $request->adresse['adresse'],
                                'gouvernorat' => $request->adresse['gouvernorat'],
                                'gouvernorat_id' => 1,
                        ]);
            return response()->json('association modifiee!', 200); 
        }else{
            return response()->json('Aucune association trouvee', 405);
        }
                    
    }

    public function deleteAssociation(Request $request, Association $association){
        // $association = Association::where('id', $request->associationId)->first();
        if($association->id){
            $association->delete();
            return response()->json('association supprimee!', 200);    
        }else{
            return response()->json('Aucune association trouvee', 405);
        }
    }


    public function addGouvernorats(Request $request){
        foreach($request->gouvernorats as $value){
            $gouvernorat = new Gouvernorat();
            $gouvernorat->nom = $value;
            $gouvernorat->save();
        }
    }
}
