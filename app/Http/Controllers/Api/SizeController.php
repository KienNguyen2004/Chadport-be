<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    // Lấy thông tin kích thước theo ID
    public function show($id)
    {
        $size = Size::find($id);

        if (!$size) {
            return response()->json(['message' => 'Size not found'], 404);
        }

        return response()->json(['data' => $size], 200);
    }

    // Tạo mới kích thước
    public function creates(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:sizes,name',
        ]);

        if ($validated) {
            $size = Size::create([
                'name' => $request->input('name'),
            ]);
        }

        return response()->json([
            'data' => $size
        ], 201);
    }

    // Lấy tất cả kích thước
    public function GetAll(Request $request)
    {
        $sizes = Size::all();

        return response()->json([
            'data' => $sizes
        ], 200);
    }

    // Cập nhật kích thước
    public function updates(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:sizes,name,' . $id,
        ]);

        if ($validated) {
            $size = Size::where('id', $id)->update([
                'name' => $request->input('name'),
            ]);
        }

        return response()->json([
            'data' => $size
        ], 200);
    }

    // Xóa kích thước
    public function destroy(Request $request, string $id)
    {
        $size = Size::where('id', $id)->delete();

        return response()->json([
            'message' => 'Size deleted successfully'
        ], 200);
    }
}
