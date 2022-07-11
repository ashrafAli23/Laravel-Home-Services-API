<?php

namespace App\Http\Controllers;

use App\Models\ServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
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
            "password" => Hash::make($request->password)
        ]);

        if ($request->type === 'service_provider') {
            ServiceProvider::create([
                'user_id' => $inserUserData->id
            ]);
        }

        $token = $inserUserData->createToken($request->email)->plainTextToken;
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
     * User profile
     */

    public function profile(Request $request)
    {
        return response(["user" =>  Auth::user()], Response::HTTP_CREATED);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|min:8',
            'phone' => 'required|min:11',
            'image' => 'required|file|mimes:png,jpeg,jpg',
        ]);

        $imageName = $request->file('image');
        $imagePath = $imageName->storeAs('public/images/users', rand(1, 99999) . $imageName->getClientOriginalName());

        $user = User::where('id', Auth::user()->id)->update([
            "name" => $request->name,
            "phone" => $request->phone,
            "image" => $imagePath
        ]);

        return response(["message" =>  "User updated success"], Response::HTTP_CREATED);
    }


    /**
     * USer logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}
