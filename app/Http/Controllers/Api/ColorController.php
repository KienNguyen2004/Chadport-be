<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ColorRequest;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $color = Color::all();
        return  ColorResource::collection($color);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColorRequest $request)
    {
        if ($request->isMethod('POST')) {
            $params = $request->all();
            
            if ($request->hasFile('image')) {
                $fileName = $request->file('image')->store('uploads/color', 'public');
            }else{
                $fileName= null;
            }
            $params['image']= $fileName;
            
            $newcolor = Color::create($params);
            return new ColorResource($newcolor);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $color = Color::query()->findOrFail($id);
        if (!$color) {
            return response()->json(['message' => 'Không tìm thấy màu sắc'], 404);
        }
        return new ColorResource($color);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColorRequest $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->all();
            $color = Color::findOrFail($id);

            if ($request->hasFile('image')) {

                if ($color->image) {
                    Storage::disk('public')->delete($color->image);
                }
                $params['image'] = $request->file('image')->store('uploads/sanpham', 'public');
            } else {
                $params['image'] = $color->image;
            }
            
            $color->update($params);
            return new ColorResource($color);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        return response()->json([
            'message' => 'Xóa thành công!!'
        ], 200);
    }
}
