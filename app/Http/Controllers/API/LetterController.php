<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LetterController extends Controller
{
    // get  all letters from the database and return it as a response.
    public function index() {
        return Letter::all();
    }

    // save  new letter to the database, create a new instance of the model

    public function store(Request $request) {

        $request->validate(
            [
                'email'=>'required|email'
            ]
            );

        $letters = new Letter(
            [
                'id'=>Str::random(6),
                'email'=>Request('email')
            ]
            );
            $letters->save();
            return Response()->json([
                "message"=>"le mail est bien enregistré",
            ],200);
    }

    public function destroy(string $id)
    {
        $letters =  Letter::findOrFail($id);
        if(!$letters)
        {
            return  Response()->json(['message'=>'ce mail n\'existe pas'],404);
        }

        $letters->delete();
        return  Response()->json(['message'=>'le mail a été supprimé']);
    }
}