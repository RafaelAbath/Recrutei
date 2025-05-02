<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /** POST /api/register */
    public function register(RegisterRequest $request)
    {
        // cria o usuário
        $user = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => $request->password,   // <- sem Hash::make
        ]);

        // gera token
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), Response::HTTP_CREATED); // 201
    }

    /** POST /api/login */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(compact('token')); // 200
    }

    /** POST /api/logout */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Logged out']); // 200
    }
}
