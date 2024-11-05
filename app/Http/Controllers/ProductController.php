<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function createProducts(Request $request)
{
    // Lấy các dữ liệu đầu vào trừ `image_description`
    $data = $request->only([
        'cat_id', 'title', 'name', 'status', 'col_id', 'size_id', 'brand_id',
        'description', 'quantity', 'image_product', 
        'price', 'price_sale', 'type', 'size', 'color'
    ]);

    // Xác thực dữ liệu đầu vào, bao gồm các ảnh trong `image_description`
    $validated = $request->validate([
        'cat_id' => 'required|exists:categories,id', 
        'title' => 'required|max:255',
        'name' => 'required|max:500',
        'status' => 'required|in:active,inactive',
        'col_id' => 'nullable|exists:colors,id',
        'size_id' => 'nullable|exists:sizes,id',
        'brand_id' => 'nullable|exists:brands,id',
        'description' => 'nullable|string',
        'quantity' => 'required|integer|min:0',
        'image_product' => 'required|max:255',
        'image_description.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Từng ảnh trong `image_description`
        'price' => 'required|numeric|min:0',
        'price_sale' => 'nullable|numeric|min:0',
        'type' => 'nullable|string|max:50',
        'size' => 'nullable|string|max:20',
        'color' => 'nullable|string|max:20',
    ]);

    // Xử lý việc upload các file và lưu đường dẫn vào mảng
    if ($request->hasFile('image_description')) {
        foreach ($request->file('image_description') as $file) {
            $path = $file->store('images', 'public');
            $imagePaths[] = $path;
        }
    }

    // Lưu đường dẫn ảnh dưới dạng JSON vào `image_description`
    $data['image_description'] = json_encode($imagePaths);

    // Tạo sản phẩm mới sau khi đã xử lý và xác thực dữ liệu
    $product = Product::create($data);

    return response()->json([
        'data' => $product, 
        'imagePaths' => $imagePaths, // Log để kiểm tra
        'message' => 'Product created with images successfully'
    ], 201);
}
}
