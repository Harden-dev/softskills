<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Devis;
use Exception;
use Illuminate\Http\Request;

class DevisController extends Controller
{
    //
    //
    public function index()
    {
        return Devis::all();

    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nature_client'=>'required',
                'type_service'=>'required',
                'budget'=>'required',
                'nom_client'=>'required',
                'num_tel'=>'required',
                'email'=>'required|email',
                'description'
               
            ]
            );
            try {
                $devis = new Devis(
                    [
                     'nature_client'=>Request('nature_client'),
                     'type_service'=>Request('type_service'),
                     'budget'=>Request('budget'),
                     'nom_client'=>Request('nom_client'),
                     'num_tel'=>Request('num_tel'),
                     'email'=>Request('email'),
                     'description'=>Request('description')
                    ] 
                    );
                
                $devis->save();
                return response()->json(['message'=>'enregistrement réussi!']);
            } catch (Exception $e) {
              return response()->json(['message'=>'enregistrement échoué !']);
            }
      
    }
}
