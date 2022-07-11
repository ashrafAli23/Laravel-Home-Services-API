<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:8',
            'phone' => 'required|min:11',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin) {
            return response([
                'message' => ['This user already exists.']
            ], Response::HTTP_UNAUTHORIZED);
        }

        $inserAdminData = Admin::create([
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            "status" => 0,
            "password" => Hash::make($request->password)
        ]);

        $token = $inserAdminData->createToken($request->email)->plainTextToken;
        return response([
            'user' => $inserAdminData,
            "token" => $token
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response([
                'message' => ['Invalid Email or password.']
            ], Response::HTTP_NOT_FOUND);
        }

        $token = $admin->createToken($admin->email)->plainTextToken;

        return response([
            'user' => $admin,
            'token' => $token
        ], Response::HTTP_CREATED);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}
