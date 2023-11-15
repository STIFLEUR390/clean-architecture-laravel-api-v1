<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Créer un utilisateur
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     *
     * @unauthenticated
     *
     * @response array{success: bool, message: string, data: array{accessToken: string}}
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users',
                'password' => 'required|string',
                'c_password' => 'required|same:password',
            ]);

            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return $this->createdResponse('ok', [
                'accessToken' => $token,
            ]);
        } catch (\Exception $e) {
            // return response()->json(['error' => 'Provide proper details']);
            return $this->clientErrorResponse($e->getMessage(), $e->getCode(), $error = null);
        }
    }

    /**
     * Connectez-vous à l'utilisateur et créez un jeton
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     *
     * @unauthenticated
     *
     * @response array{success: bool, message: string, data: array{accessToken: string, token_type: string}}
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean',
        ]);

        $credentials = request(['email', 'password']);
        if (! Auth::attempt($credentials)) {
            /* return response()->json([
                'message' => 'Unauthorized',
            ], 401); */
            return $this->unauthenticatedResponse('Unauthorized');
        }

        $user = $request->user();
        $tokenResult = $user->createToken($user->name);
        $token = $tokenResult->plainTextToken;

        /* return response()->json([
            'accessToken' => $token,
            'token_type' => 'Bearer',
        ]); */
        return $this->okResponse('ok', [
            'accessToken' => $token,
            'token_type' => 'Bearer',
        ]);

    }

    /**
     * Obtenez l'utilisateur authentifié
     *
     * @response array{success: bool, message: string, data: UserResource ,}
     */
    public function user(Request $request)
    {
        // return response()->json($request->user());

        return $this->resourceResponse(new UserResource($request->user()), 'ok');
    }

    /**
     * Déconnexion de l'utilisateur (révoquer le jeton)
     *
     * @response array{success: bool, message: string}
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        /* return response()->json([
            'message' => 'Successfully logged out',
        ]); */
        return $this->okResponse('ok');

    }

    /**
     * Actualiser le token utilisateur
     *
     * @param  mixed  $request
     *
     * @response array{success: bool, message: string, data: array{accessToken: string}}
     */
    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return $this->okResponse('ok', ['accessToken' => $user->createToken($user->name)->plainTextToken]);
    }
}
