<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    public function index(Request $request, $category_slug)
    {

        $category = ServiceCategory::where('slug', $category_slug)->first();
        return $category;
    }

    public function getByPaginate()
    {
        $service = Service::paginate(10);
        return $service;
    }

    public function getServicesByCategory(Request $request, $category_slug)
    {

        try {
            $category = ServiceCategory::where('slug', $category_slug)->first();
            $service = Service::where('service_category_id', $category->id)->paginate(10);
        } catch (\Throwable $th) {
            return response(["error" => "Invalid data not found"], Response::HTTP_NOT_FOUND);
        }
        return [
            'service' => $service,
            'category_name' => $category->name
        ];
    }

    public function addNewService(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'slug' => 'required|min:3',
            'tagline' => 'required',
            'service_category_id' => 'required',
            'price' => 'required',
            'image' => 'required|file|mimes:png,jpeg,jpg',
            'description' => 'required|min:3',
            'inclusion' => 'required|min:3',
            'exclusion' => 'required|min:3',
        ]);

        $imageName = $request->file('image');
        $imagePath = $imageName->storePubliclyAs('public/images/services', rand(1, 99999) . $imageName->getClientOriginalName());

        try {
            ServiceCategory::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'tagline' => $request->tagline,
                'service_category_id' => $request->service_category_id,
                'price' => $request->price,
                'image' => $imagePath,
                'description' => $request->description,
                'inclusion' => $request->inclusion,
                'exclusion' => $request->exclusion

            ]);
        } catch (\Throwable $th) {
            return response(["message" => $th->getMessage()], Response::HTTP_EXPECTATION_FAILED);
        }

        return response([
            "message" => "Serviec added success"
        ], Response::HTTP_CREATED);
    }

    public function updateService(Request $request, $service_slug)
    {
        $request->validate([
            'name' => 'required|min:3',
            'slug' => 'required|min:3',
            'tagline' => 'required',
            'service_category_id' => 'required',
            'price' => 'required',
            'image' => 'required|file|mimes:png,jpeg,jpg',
            'description' => 'required|min:3',
            'inclusion' => 'required|min:3',
            'exclusion' => 'required|min:3',
        ]);

        $imageName = $request->file('image');
        $imagePath = $imageName->storePubliclyAs('public/images/services', rand(1, 99999) . $imageName->getClientOriginalName());

        try {
            Service::where('slug', $service_slug)->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'tagline' => $request->tagline,
                'service_category_id' => $request->service_category_id,
                'price' => $request->price,
                'discount' => $request->discount,
                'discount_type' => $request->discount_type,
                'image' => $imagePath,
                'description' => $request->description,
                'inclusion' => $request->inclusion,
                'exclusion' => $request->exclusion,
                'status' => $request->status
            ]);
        } catch (\Throwable $th) {
            return response(["error" => "update service failed"], Response::HTTP_EXPECTATION_FAILED);
        }

        return response([
            "message" => "Serviec updated success"
        ], Response::HTTP_CREATED);
    }

    public function deleteService(Request $request, $service_id)
    {
        try {
            $service = Service::find($service_id);
            $service->delete();
        } catch (\Throwable $th) {
            return response(["message" => $th->getMessage()], Response::HTTP_EXPECTATION_FAILED);
        }

        return response(["message" => "delete sucess"], Response::HTTP_CREATED);
    }
}
