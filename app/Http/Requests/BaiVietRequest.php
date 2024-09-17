<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaiVietRequest extends FormRequest
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
            "content" => "required",
        ];
    
        if ($this->route()->getName() !== 'baiviet.update') {
            $rules["image"] = "required|image";
        } else {
            $rules["image"] = "image";
        }
    
        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Không được để trống tiêu đề bài viết',
            'image.required' => 'Không được để trống ảnh đại diện bài viết',
            'image.image' => 'Vui lòng chọn file có định dạng là ảnh',
            'content.required' => 'Không được để trống nội dung bài viết'
        ];
    }
}