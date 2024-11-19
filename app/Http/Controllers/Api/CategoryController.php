<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listcategories = Category::all();

        return CategoryResource::collection($listcategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->method('POST')) {
            $prams = $request->all();

            $newCategory = Category::create($prams);
            return new CategoryResource($newCategory);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
    
        return response()->json(['data' => $category], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->all();
            $category = Category::findOrFail($id);
            $category->update($params);
            return new CategoryResource($category);
        }
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
        'message'=>'Xóa thành công',
        'data' => $categoriess
       ], 201);
    }
}
