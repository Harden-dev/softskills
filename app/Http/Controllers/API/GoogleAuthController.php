<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class GoogleAuthController extends Controller
{
    /**
     * Redirige l'utilisateur vers la page de connexion Google
     * @OA\Schema(
     *     schema="GoogleAuthController",
     *     @OA\Property(
     *         property="url",
     *         type="string",
     *         example="https://localhost:8000/api/v2/google/callback"
     *     )
     * )
     */

    /** 
     * @OA\Get(
     *      path="/api/v2/auth/google",
     *      operationId="redirectToGoogle",
     *      tags={"Google"},
     *      summary="Redirect to Google login",
     *      description="Redirect to Google login",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *         )
     *       ),  
     *      @OA\Response(
     *          response=400,
     *          description="Error retrieving Google login"
     *      )

     *  )
     */
    public function redirectToGoogle()
    {
        $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();

        // En développement, retournez l'URL pour faciliter les tests
        if (config('app.env') === 'local') {
            return response()->json(['url' => $url]);
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the Google callback
     * @OA\Get(
     *      path="/api/v2/auth/google/callback",
     *      operationId="handleGoogleCallback",
     *      tags={"Google"},
     *      summary="Handle Google callback",
     *      description="Handle Google callback",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *        )
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="Error handling Google callback"
     *      )
     *  )
     */
    public function handleGoogleCallback()
    {
        try {
            // Ajout de logs pour debug
            Log::info('Starting Google callback');
            
        $googleUser = Socialite::driver('google')
                ->stateless()
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->user();

            Log::info('Google user data received', ['email' => $googleUser->email]);

            
            $existingUser = User::where('email', $googleUser->email)->first();

            if ($existingUser) {

                if (empty($existingUser->google_id)) {
                    $existingUser->update([
                        'google_id' => $googleUser->getId()
                    ]);
                }
                $token = JWTAuth::fromUser($existingUser);
                return response()->json([
                    'success' => true,
                    'message' => 'User logged in successfully',
                    'token' => $token,
                    'data' => $existingUser,
                ]);
            }

            $newUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->getId(),
                'password' => Hash::make(Str::random(16)),
            ]);

            $token = JWTAuth::fromUser($newUser);

            return response()->json([
                'success' => true,
                'message' => 'User registered and logged in successfully',
                'token' => $token,
                'data' => $newUser,
            ]);
        } catch (\Exception $e) {
            Log::error('Google callback error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error logging in with Google',
                'error' => $e->getMessage(),
                'debug_info' => [
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ], 500);
        }
    }
}
