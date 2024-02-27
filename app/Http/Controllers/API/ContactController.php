<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
                    'id'=>Str::random(6),
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

    public function destroy(string $id)
    {
        $contact = Contact::find($id);
        if(!$contact)
        {
            return response()->json(['message'=>'contact non dispo'],401);
        }

        $contact->delete();
        return response()->json(['message'=>'suppression reussie' ],200);  

    }
}
