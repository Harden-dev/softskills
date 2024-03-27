<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ServiceNotification;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
                $service = new Service(
                    [
                    'id'=>Str::random(6),
                     'nom_prenom'=>Request('nom_prenom'),
                     'email'=>Request('email'),
                     'contact'=>Request('contact'),
                     'type_services'=>Request('type_services')
                    ] 
                    );
                
                $service->save();

                $adminEmail = 'micstech.28@gmail.com';
                $directionEmail= 'direction@softskills.ci';

                $serviceDetails = [
                    'nom_prenom' => $service->nom_prenom,
                    'email' => $service->email,
                    'contact' => $service->contact,
                    'type_services' =>$service->type_services,
                    
                ];
                
                Mail::to($adminEmail)->cc($directionEmail)->send(new ServiceNotification($serviceDetails));
                return response()->json(['message'=>'enregistrement réussi!']);
            } catch (Exception $e) {
              return response()->json(['message'=>'enregistrement échoué !']);
            }
      
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        if(!$service)
        {
            return response()->json(['message'=>'service non dispo'],401);
        }

        $service->delete();
        return response()->json(['message'=>'suppression reussie' ],200);  

    }
}
