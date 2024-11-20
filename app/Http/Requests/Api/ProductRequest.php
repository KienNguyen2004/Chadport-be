<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cat_id' =>['required','exists:categories,cat_id'],
            'title'=>['required','string','max:255','unique:products,title'],
            'name' => ['required','string','max:255','unique:prooducts,pro_name'],
            'status'=>['required','boolean'],
            'brand_id'=>['required','exists:brands,brand_id'],
            'description'=>['required','string','max:255'],
            'quantity'=>['required','integer','min:0'],
            // bắt buộc phải nhập- kiểu số nguyên và nhỏ nhất kà 0
            'image_product'=>['required','image','mimes:png,jpg,jpeg,gif','max:2048'],
            // bắt buộc phải nhập- kiểu ảnh - định dangj đuôi png,jpg,jpeg,gif - kích thước ảnh 2048 
            'image_description'=>['required','image','mimes:png,jpg,jpeg,gif','max:2048'],

            'price'=>['required','numeric','min:0'],
            // bắt buộc phải nhập- kiểu số nguyên hoặc số thực 
            'price_sale'=>['required','numeric','min:0','lt:price'],
            // bắt buộc phải nhập- kiểu số nguyên hoặc số thực -- lt: là đảm bảo giá sale nhỏ hơn giá gốc
            'type'=>['nullable','string','max:255'],
            
            // 'size_id'=>['required','exists:sizes,size_id'],
            // 'col_id'=>['required','exists:colors,col_id'],
            
           
            
           
            
            
        ];
    }
}
