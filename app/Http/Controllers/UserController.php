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
}
