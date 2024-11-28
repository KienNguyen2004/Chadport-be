<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductItems;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProductControllers extends Controller
{
    public function createProducts(Request $request)
    {
        // Lấy các dữ liệu đầu vào
        $data = $request->only([
            'category_id',
            'title',
            'name',
            'status',
            'description',
            'quantity',
            'image_product',
            'price',
            'price_sale',
            'type',
            'total_quatity',
            'variants'
        ]);
    
        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|max:255',
            'name' => 'required|max:500',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'quantity' => 'nullable|integer|min:0',
            'image_product' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_description' => 'nullable|array',
            'image_description.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'price_sale' => 'nullable|numeric|min:0|',
            'total_quatity' => 'nullable|integer|min:0',
            'type' => 'nullable|string|max:50',
            'variants' => 'required|string' // Dữ liệu `variants` được yêu cầu là chuỗi JSON
        ]);
    
        // Giải mã phần `variants`
        $decodedVariants = json_decode($validated['variants'], true);
    
        if (!is_array($decodedVariants)) {
            return response()->json(['message' => 'Invalid format for variants'], 422);
        }
    
        // Chuyển giá sản phẩm và giá giảm giá thành số nguyên (VND)
        $price = intval($validated['price']); // Làm tròn giá gốc thành số nguyên
        $priceSale = isset($validated['price_sale']) ? intval($validated['price_sale']) : 0; // Làm tròn giá giảm giá thành số nguyên

        // Kiểm tra nếu giá giảm lớn hơn giá gốc, trả lỗi
        if ($priceSale > $price) {
            return response()->json(['message' => 'Price sale cannot be greater than the original price'], 422);
        }

        // Lưu ảnh chính của sản phẩm
        if ($request->hasFile('image_product')) {
            $imageProductPath = $request->file('image_product')->store('images', 'public');
            $data['image_product'] = $imageProductPath;
        }
    
        // Xử lý việc upload các file và lưu đường dẫn vào mảng
        if ($request->hasFile('image_description')) {
            $imagePaths = [];
            foreach ($request->file('image_description') as $file) {
                $path = $file->store('images', 'public');
                $imagePaths[] = $path;
            }
            $data['image_description'] = json_encode($imagePaths);
        }
    
        // Gán giá trị mặc định cho `total_quantity` nếu không được truyền
        $data['total_quatity'] = $data['total_quatity'] ?? 0;
        $data['price'] = $price; // Gán giá trị cho `price`
        $data['price_sale'] = $priceSale; // Gán giá trị cho `price_sale`

        // Tạo sản phẩm mới sau khi đã xử lý và xác thực dữ liệu
        $product = Product::create($data);
    
        // Xử lý lưu biến thể với nhiều size và color
        foreach ($decodedVariants as $variantData) {
            foreach ($variantData['size_id'] as $sizeId) {
                foreach ($variantData['color_id'] as $colorId) {
                    ProductItems::create([
                        'product_id' => $product->id,
                        'size_id' => $sizeId,
                        'color_id' => $colorId,
                        'quantity' => $variantData['quantity'],
                        'type' => $variantData['type'] ?? null,
                    ]);
                }
            }
        }
    
        return response()->json([
            'data' => $product->load(['productItems.size', 'productItems.color']),
            'message' => 'Product and variants created successfully'
        ], 201);
    }
    
    public function showProduct(Request $request)
    {
        // Số lượng sản phẩm hiển thị trên mỗi trang
        $perPage = 10;

        // Sử dụng phân trang Laravel với số lượng sản phẩm trên mỗi trang là $perPage
        $listProduct = Product::paginate($perPage);

        // Trả về danh sách sản phẩm và thông tin phân trang
        return response()->json([
            'data' => $listProduct->items(),
            'current_page' => $listProduct->currentPage(),
            'last_page' => $listProduct->lastPage(),
            'total' => $listProduct->total(),
        ], 200);
    }

    public function showShopProducts(Request $request)
    {
        // Số sản phẩm trên mỗi trang
        $perPage = 15;

        // Lấy danh sách sản phẩm với phân trang
        $listProduct = Product::paginate($perPage);

        // Trả về dữ liệu sản phẩm và thông tin phân trang
        return response()->json([
            'data' => $listProduct->items(), // Danh sách sản phẩm
            'current_page' => $listProduct->currentPage(), // Trang hiện tại
            'last_page' => $listProduct->lastPage(), // Trang cuối cùng
            'total' => $listProduct->total(), // Tổng số sản phẩm
            'per_page' => $perPage, // Số sản phẩm mỗi trang
        ], 200);
    }

    // Phương thức để lấy thông tin chi tiết của sản phẩm theo ID
    public function showDetail($id)
{
    // Tìm Product theo ID và eager load các quan hệ: variants, size, color
    $product = Product::with('variants.size', 'variants.color')->find($id);

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
                'image_product' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'image_description' => 'nullable|array',
                'image_description.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'price' => 'sometimes|numeric|min:0',
                'price_sale' => 'nullable|numeric|min:0',
                'type' => 'nullable|string|max:50',
                'size' => 'nullable|string|max:20',
                'color' => 'nullable|string|max:20',
            ]);

            
            // Lấy dữ liệu đầu vào từ yêu cầu
            $data = $validated;
            // Lưu ảnh chính của sản phẩm
            if ($request->hasFile('image_product')) {
                $imageProductPath = $request->file('image_product')->store('images', 'public');
                $data['image_product'] = $imageProductPath; // Lưu đường dẫn ảnh mới
            } else {
                // Nếu không có ảnh mới, giữ lại ảnh cũ (không thay đổi)
                $existingProduct = Product::find($id);
                if ($existingProduct && $existingProduct->image_product) {
                    $data['image_product'] = $existingProduct->image_product; // Giữ lại ảnh cũ
                }
            }
            


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
            // Tìm sản phẩm theo id
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

    public function getProductsByCategory($cat_id)
    {
        // Lấy tất cả sản phẩm theo danh mục
        $products = Product::where('cat_id', $cat_id)->get();

        // Kiểm tra nếu không có sản phẩm nào
        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found in this category'], 404);
        }

        // Trả về danh sách sản phẩm dưới dạng JSON
        return response()->json([
            'data' => $products
        ], 200);
    }
    public function getCategories(Request $request)
    {
        $perPage = 3; // Số lượng items mỗi trang
        $categories = Category::paginate($perPage);

        return response()->json([
            'data' => $categories->items(), // Dữ liệu danh mục
            'current_page' => $categories->currentPage(), // Trang hiện tại
            'last_page' => $categories->lastPage(), // Trang cuối
            'total' => $categories->total(), // Tổng số danh mục
        ], 200);
    }

    public function showProductById($id)
{
    $product = Product::find($id); // Tìm sản phẩm theo id

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404); // Nếu không tìm thấy sản phẩm
    }

    return response()->json(['data' => $product], 200); // Trả về sản phẩm tìm thấy
}
}