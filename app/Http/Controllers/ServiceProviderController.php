<?php

namespace App\Http\Controllers;

use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ServiceProviderController extends Controller
{

    public function profile(Request $request)
    {
        $provider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        return response(["user" => ['provider' => $provider, 'data' => Auth::user()]], Response::HTTP_CREATED);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'city' => 'required',
            'about' =>  'required|min:8',
            'service_category_id' => 'required',
            'service_locations' => 'required',
        ]);

        $provider = ServiceProvider::where('user_id', Auth::user()->id)->update([
            'city' => $request->city,
            'about' => $request->about,
            'service_category_id' => $request->service_category_id,
            'service_locations' => $request->service_locations,
        ]);
        return response(["message" => "Success Update"], Response::HTTP_CREATED);
    }
}
