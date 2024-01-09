<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    //
    public function index()
    {
        return Service::all();

    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nom_prenom'=>'required',
                'email'=>'required|email',
                'contact'=>'required',
                'type_services'=>'required',
               
            ]
            );
            try {
                $contact = new Service(
                    [
                     'nom_prenom'=>Request('nom_prenom'),
                     'email'=>Request('email'),
                     'contact'=>Request('contact'),
                     'type_services'=>Request('type_services')
                    ] 
                    );
                
                $contact->save();
                return response()->json(['message'=>'enregistrement réussi']);
            } catch (Exception $e) {
              return response()->json(['message'=>'enregistrement rejeté']);
            }
      
    }
}
