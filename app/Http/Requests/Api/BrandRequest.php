<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'name'=>['required','string','max:255','unique:brands,brand_name'],
            // bắt buộc phải nhập kiểu dữ liệu là String độ và tối đa 255 kí tự không được trùng tên
            'description'=>['nullable','string','max:255'],
        ];
    }
}
