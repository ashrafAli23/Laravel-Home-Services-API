<?php

namespace App\Http\Controllers;

use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ServiceProviderController extends Controller
{
    public function createService(Request $request)
    {
        $request->validate([
            'city' => 'required|min:3',
            'about' => 'required|min:10',
            'service_locations' => 'required',
            'service_category_id' => 'required|numeric'
        ]);

        ServiceProvider::create([
            'user_id' => Auth::user()->id,
            'city' => $request->city,
            'about' => $request->about,
            'service_locations' => $request->service_locations,
            'service_category_id' => $request->service_category_id
        ]);

        return response(["message" => "Success"], Response::HTTP_CREATED);
    }

    public function getProfileDetailes()
    {
        $provider = ServiceProvider::with(['user', 'category'])->first();
        return response(["provider" => $provider], Response::HTTP_OK);
    }
}
