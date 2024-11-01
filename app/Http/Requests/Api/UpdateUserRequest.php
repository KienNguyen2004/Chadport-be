<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'first_name' => 'nullable|string|max:20',
            'last_name' => 'nullable|string|max:20',
            'gender' => 'nullable|integer',
            'birthday' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'image_user' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'nullable|string|unique:users,phone_number,' . $this->input('id') . ',user_id',
        ];
    } 
    
}
