<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        try {
            if (! $token = $this->jwt->attempt($request->only('email', 'password'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email ou senha inválido',
                ], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token expirado',
            ], 500);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido',
            ], 500);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token ausente',
            ], 500);
        }

        /** @var User $user */
        $user = Auth::user();
        $user = $user->only(['id', 'name', 'email']);
        $user['image'] = url('/images/user.png');

        return response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    public function postLogout(Request $request)
    {
        Auth::logout();
        $this->jwt->parseToken()->invalidate();

        return response()->json(['message'=>'token removed']);
    }
}
