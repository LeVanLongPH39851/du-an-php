<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DanhMucRequest extends FormRequest
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
        $rules = [
            "name" => "required",
        ];
    
        if ($this->route()->getName() !== 'danhmuc.update') {
            $rules["image"] = "required|image";
        } else {
            $rules["image"] = "image";
        }
    
        return $rules;
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'Không được để trống tên danh mục',
            'image.required' => 'Không được để trống ảnh danh mục',
            'image.image' => 'Vui lòng chọn file có định dạng là ảnh'
        ];
    }
}