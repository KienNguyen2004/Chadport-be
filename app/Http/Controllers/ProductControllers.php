<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductControllers extends Controller
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
            'image_product' => 'required|max:1000',
            'image_description' => 'nullable|array',
            'image_description.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'price_sale' => 'nullable|numeric|min:0',
            'type' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:20',
            'color' => 'nullable|string|max:20',
        ]);

        $data = $validated;

        // Xử lý việc upload các file và lưu đường dẫn vào mảng
        if ($request->hasFile('image_description')) {
            $imagePaths = [];  // Khởi tạo mảng để lưu đường dẫn
            foreach ($request->file('image_description') as $file) {
                $path = $file->store('images', 'public');
                $imagePaths[] = $path; // Thêm đường dẫn ảnh vào mảng
                Log::info($file->getClientMimeType());
            }
            $data['image_description'] = json_encode($imagePaths);  // Lưu đường dẫn ảnh dưới dạng JSON
        }

        // Tạo sản phẩm mới sau khi đã xử lý và xác thực dữ liệu
        $product = Product::create($data);

        return response()->json([
            'data' => $product, 
            'imagePaths' => $imagePaths, // Log để kiểm tra
            'message' => 'Product created with images successfully'
        ], 201);
    }

    public function showProduct (Request $request)
    {
        $listProduct = Product::all();

        return response()->json([
            'data'=> $listProduct,
        ],201);
    }

    // Phương thức để lấy thông tin chi tiết của sản phẩm theo ID
    public function showDetail($id)
    {
        // Tìm sản phẩm theo ID
        $product = Product::find($id);

        // Nếu sản phẩm không tồn tại, trả về lỗi 404
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Trả về thông tin sản phẩm dưới dạng JSON
        return response()->json($product);
    }

    public function updateProduct(Request $request, $id)
    {
        try {
            // Xác thực các dữ liệu đầu vào
            $validated = $request->validate([
                'cat_id' => 'sometimes|exists:categories,id',
                'title' => 'sometimes|max:255',
                'name' => 'sometimes|max:500',
                'status' => 'sometimes|in:active,inactive',
                'col_id' => 'nullable|exists:colors,id',
                'size_id' => 'nullable|exists:sizes,id',
                'brand_id' => 'nullable|exists:brands,id',
                'description' => 'nullable|string',
                'quantity' => 'sometimes|integer|min:0',
                'image_product' => 'required|max:255',
                'image_description' => 'nullable|array',
                'image_description.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'price' => 'sometimes|numeric|min:0',
                'price_sale' => 'nullable|numeric|min:0',
                'type' => 'nullable|string|max:50',
                'size' => 'nullable|string|max:20',
                'color' => 'nullable|string|max:20',
            ]);

            // Lấy dữ liệu đầu vào từ yêu cầu
            $data = $validated;
                        // Xử lý upload các file hình ảnh mô tả nếu có
            if ($request->hasFile('image_description')) {
                $imagePaths = [];
                foreach ($request->file('image_description') as $file) {
                    $path = $file->store('images', 'public');
                    $imagePaths[] = $path;
                }
                $data['image_description'] = json_encode($imagePaths);
            }

            $product = Product::find($id);


            // Cập nhật thông tin sản phẩm
            $product->update($data);
            // Lấy tất cả dữ liệu sản phẩm sau khi cập nhật
            
            // Trả về phản hồi JSON với dữ liệu đã cập nhật
            return response()->json([
                'status' => 'success',
                'message' => 'Sản phẩm đã được cập nhật thành công!',
                'data' => $product
            ], 200);

        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return response()->json([
                'status' => 'error',
                'message' => 'Lỗi khi cập nhật sản phẩm!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    public function destroy(Request $request, string $id)
    {
        try {
            // Tìm sản phẩm theo `id`
            $product = Product::where('id', $id)->first();
    
            // Kiểm tra xem sản phẩm có tồn tại không
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không tìm thấy sản phẩm để xóa!'
                ], 404);
            }
    
            // Nếu sản phẩm tồn tại, thực hiện xóa
            $product->delete();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Sản phẩm đã được xóa thành công!',
                'data' => $product
            ], 200);
    
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return response()->json([
                'status' => 'error',
                'message' => 'Lỗi khi xóa sản phẩm!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
}
