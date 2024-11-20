<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SizeRequest;
use App\Http\Resources\SizeResource;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $size = Size::all();
        return  SizeResource::collection($size);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SizeRequest $request)
    {
        if ($request->isMethod('POST')) {
            $params = $request->all();

            $newsize = Size::create($params);
            return new SizeResource($newsize);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $size = Size::query()->findOrFail($id);
        if (!$size) {
            return response()->json(['message' => 'Không tim thấy Size'], 404);
        }
        return new SizeResource($size);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SizeRequest $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->all();
            $size = Size::findOrFail($id);
            $size->update($params);
            return new SizeResource($size);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Size::findOrFail($id);
        $brand->delete();
        return response()->json([
            'message' => 'Xóa thành công!!'
        ], 200);
    }
}
