<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    // Lấy thông tin variant theo ID
    public function show($id)
    {
        $variant = ProductVariant::find($id);

        if (!$variant) {
            return response()->json(['message' => 'Variant not found'], 404);
        }

        return response()->json(['data' => $variant], 200);
    }

    // Tạo mới variant
    public function creates(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id', // Validate product_id
        'size_id' => 'required|exists:sizes,id',
        'color_id' => 'required|exists:colors,id',
        'quatity' => 'required|integer|min:1',
    ]);

    $variant = ProductVariant::create([
        'product_id' => $request->input('product_id'), // Lưu product_id
        'size_id' => $request->input('size_id'),
        'color_id' => $request->input('color_id'),
        'quatity' => $request->input('quatity'),
    ]);

    return response()->json(['data' => $variant], 201);
}

    // Lấy tất cả variants
    public function GetAll(Request $request)
    {
        $variants = ProductVariant::with(['size', 'color'])->get();

        return response()->json([
            'data' => $variants
        ], 200);
    }

    // Cập nhật variant
    public function updates(Request $request, string $id)
    {
        $validated = $request->validate([
            'size_id' => 'required|exists:sizes,id',
            'color_id' => 'required|exists:colors,id',
            'quatity' => 'required|integer',
        ]);

        if ($validated) {
            $variant = ProductVariant::where('id', $id)->update([
                'size_id' => $request->input('size_id'),
                'color_id' => $request->input('color_id'),
                'quatity' => $request->input('quatity'),
            ]);
        }

        return response()->json([
            'data' => $variant
        ], 200);
    }

    // Xóa variant
    public function destroy(Request $request, string $id)
    {
        $variant = ProductVariant::where('id', $id)->delete();

        return response()->json([
            'message' => 'Variant deleted successfully'
        ], 200);
    }
}
