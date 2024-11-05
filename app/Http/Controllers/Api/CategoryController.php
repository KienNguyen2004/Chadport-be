<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function show($id)
{
    $category = Category::find($id);

    if (!$category) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    return response()->json(['data' => $category], 200);
}


    // khởi tạo dữ liệu
    public function creates(Request $request)
    {
       $categories_name = $request->input("name");
       $categories_status = $request->input("status");
       $categories_imageURL = $request->input("imageURL");

       $validated = $request->validate([
        'name' => 'required|max:50',
        'status' => 'required|in:active,inactive', 
        'imageURL' => 'required|max:255',
    ]);
        if ($validated) {
            $categoriess = Category::create([
             'name' => $categories_name,
             "status" =>  $categories_status,
             "imageURL" =>  $categories_imageURL
            ]);
        }

       return response()->json([
        'data' => $categoriess
       ], 201);
    }

    // get all dữ liệu danh mục
    public function GetAll(Request $request)
    {
      $listcategories = Category::all();

      return response()->json([
        'data' => $listcategories
       ], 201);
    }

    // sửa dữ liệu danh mục
    public function updates(Request $request, string $id)
    {
        // dd(1);
        $categories_name = $request->input("name");
        $categories_status = $request->input("status");
        $categories_imageURL = $request->input("imageURL");

        $validated = $request->validate([
        'name' => 'required|max:255',
        'status' => 'required|in:active,inactive',
        'imageURL' => 'nullable|max:255',
        ]);

        if ($validated) {
            $categoriess = Category::where('id', $id)->update([
                'name' => $categories_name,
                'status' => $categories_status,
                'imageURL' => $categories_imageURL,
            ]);
        }
        
        return response()->json([
            'data' => $categoriess
           ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $categories_name = $request->input("name");
        $categories_description = $request->input("description");

        $categoriess = Category::where('id', $id)->delete([
            'name' => $categories_name,
            "description" => $categories_description
        ]);

       return response()->json([
        'data' => $categoriess
       ], 201);
    }
}
