<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use function PHPSTORM_META\type;

class ServicesCategoryController extends Controller
{
    public function index(Request $request)
    {
        $category = ServiceCategory::all();
        return $category;
    }

    public function getByPaginate(Request $request)
    {
        $category = ServiceCategory::paginate(10);
        return $category;
    }

    public function addNewCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'slug' => 'required|min:2',
            "image" => 'required|file|mimes:png,jpeg,jpg'
        ]);

        $imageName = $request->file('image');
        $imagePath = $imageName->storePubliclyAs('public/images/categories', rand(1, 99999) . $imageName->getClientOriginalName());



        try {
            ServiceCategory::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => $imagePath
            ]);
        } catch (\Throwable $th) {
            return response(["message" => $th->getMessage()], Response::HTTP_EXPECTATION_FAILED);
        }

        return response([
            "message" => "Serviec category added success",
        ], Response::HTTP_CREATED);
    }

    public function updateCategory(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|min:2',
            'slug' => 'required|min:2',
            "image" => 'required|file|mimes:png,jpeg,jpg'
        ]);

        if (!$id) {
            return response(["message" => "Invalid id"], Response::HTTP_NOT_ACCEPTABLE);
        }

        $imageName = $request->file('image');
        $imagePath = $imageName->storePubliclyAs('public/images/categories', rand(1, 99999) . $imageName->getClientOriginalName());


        try {
            ServiceCategory::where('id', $id)->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => $imagePath
            ]);
        } catch (\Throwable $th) {
            return response(["message" => $th->getMessage()], Response::HTTP_EXPECTATION_FAILED);
        }

        return response([
            "message" => "Serviec category added success"
        ], Response::HTTP_CREATED);
    }

    public function deleteCategory(Request $request, $id)
    {
        try {
            $category = ServiceCategory::find($id);
            $category->delete();
        } catch (\Throwable $th) {
            return response(["message" => $th->getMessage()], Response::HTTP_EXPECTATION_FAILED);
        }

        return response(["message" => "delete sucess"], Response::HTTP_CREATED);
    }
}
