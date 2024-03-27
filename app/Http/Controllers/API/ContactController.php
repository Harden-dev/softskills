<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ContactNotification;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

                $adminEmail = 'micstech.28@gmail.com';
                $directionEmail = 'direction@softskills.ci';
                $details = [
                    'nom_prenom' => $contact->nom_prenom,
                    'email' => $contact->email,
                    'telephone' => $contact->telephone,
                    'message' =>$contact->message,
                ];
                
                Mail::to($adminEmail)->cc($directionEmail)->send(new ContactNotification($details));
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
