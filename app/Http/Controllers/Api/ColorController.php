<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    // Lấy thông tin màu theo ID
    public function show($id)
    {
        $color = Color::find($id);

        if (!$color) {
            return response()->json(['message' => 'Color not found'], 404);
        }

        return response()->json(['data' => $color], 200);
    }

    // Tạo mới màu sắc
    public function createColor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:colors,name',
            'image' => 'nullable|url',
        ], [
            'name.unique' => 'The color name is already in use. Please choose another one.',
        ]);
        
        
    
        $color = Color::create([
            'name' => $request->input('name'),
            'image' => $request->input('image'),  // Lưu URL ảnh
            'date_create' => now(),
            'date_update' => now(),
        ]);
    
        return response()->json([
            'data' => $color
        ], 201);
    }
    

    


    // Lấy tất cả màu sắc
public function GetAll(Request $request)
{
    try {
        $colors = Color::all();
        return response()->json([
            'data' => $colors
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong',
            'error' => $e->getMessage()
        ], 500);
    }
}


   // Cập nhật màu sắc
   public function updates(Request $request, string $id)
   {
       // Xác thực dữ liệu đầu vào
       $validated = $request->validate([
           'name' => 'required|string|max:50|unique:colors,name,' . $id,
           'image' => 'nullable|url',  // Xác nhận ảnh là URL hợp lệ
       ]);
   
       // Kiểm tra nếu tên màu sắc trống
       if (!$request->has('name') || empty($request->input('name'))) {
           return response()->json(['message' => 'The name field is required.'], 422);
       }
   
       // Cập nhật màu sắc
       $color = Color::find($id);
   
       if (!$color) {
           return response()->json(['message' => 'Color not found'], 404);
       }
   
       $color->name = $request->input('name');
       $color->image = $request->input('image', $color->image);  // Chỉ cập nhật ảnh nếu có URL mới
       $color->date_update = now();  // Cập nhật ngày thay đổi
   
       $color->save();
   
       return response()->json([
           'data' => $color
       ], 200);
   }
   


    // Xóa màu sắc
    public function destroy(Request $request, string $id)
    {
        $color = Color::where('id', $id)->delete();

        return response()->json([
            'message' => 'Color deleted successfully'
        ], 200);
    }
}