<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * User Register
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:8',
            'phone' => 'required|min:11',
            'email' => 'required|email',
            'type' => 'required',
            'password' => 'required|min:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response([
                'message' => ['This user already exists.']
            ], Response::HTTP_UNAUTHORIZED);
        }



        $inserUserData = User::create([
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            'type' => $request->type,
            "password" => Hash::make($request->password)
        ]);

        $token = $inserUserData->createToken($request->name)->plainTextToken;
        return response([
            'user' => $inserUserData,
            "token" => $token
        ], Response::HTTP_CREATED);
    }

    /**
     * User login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['Invalid Email or password.']
            ], Response::HTTP_NOT_FOUND);
        }

        $token = $user->createToken($user->email)->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], Response::HTTP_CREATED);
    }

    /**
     * USer logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}
