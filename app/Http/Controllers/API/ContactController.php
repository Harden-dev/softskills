<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //


    public function index()
    {
        return Contact::all();

    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nom_prenom'=>'required',
                'email'=>'required|email',
                'telephone'=>'required',
                'message'=>'required',
            ]
            );
            try {
                $contact = new Contact(
                    [
                     'nom_prenom'=>Request('nom_prenom'),
                     'email'=>Request('email'),
                     'telephone'=>Request('telephone'),
                     'message'=>Request('message')
                    ] 
                    );
                
                $contact->save();
                return response()->json(['message'=>'enregistrement réussi']);
            } catch (Exception $e) {
            //   return response()->json(['message'=>'enregistrement rejeté']);
            }
      
    }
}
