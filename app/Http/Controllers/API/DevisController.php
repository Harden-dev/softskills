<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\DevisNotification;
use App\Models\Devis;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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
                    'id'=>Str::random(6),
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
                $adminEmail = 'micstech.28@gmail.com';
                $directionEmail= 'direction@softskills.ci';
                $devisDetails = [
                    'nature_client' => $devis->nature_client,
                    'type_service' => $devis->type_service,
                    'budget' => $devis->budget,
                    'nom_client' =>$devis->nom_client,
                    'num_tel' =>$devis->num_tel,
                    'email' =>$devis->email,
                    'description' =>$devis->description,
                    
                ];
                
                Mail::to($adminEmail)->cc($directionEmail)->send(new DevisNotification($devisDetails));
                return response()->json(['message'=>'enregistrement réussi!']);
            } catch (Exception $e) {
              return response()->json(['message'=>'enregistrement échoué !']);
            }
      
    }

    public function destroy($id)
    {
        $devis = Devis::find($id);
        if(!$devis)
        {
            return response()->json(['message'=>'devis snon dispo'],401);
        }

        $devis->delete();
        return response()->json(['message'=>'suppression reussie' ],200);  

    }
}
