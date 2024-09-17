<?php

namespace App\Http\Requests\SanPhams;

use Illuminate\Foundation\Http\FormRequest;

class FormUpdateRequest extends FormRequest
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
            "name" => "required",
            "price" => "required|integer|min:1000",
            "promotion_price" => "nullable|integer|lt:price|min:999",
            'promotion_end_date' => 'nullable|date|after_or_equal:today',
            "price" => "required|integer|min:1000",
            "quantity" => "required|integer|min:1",
            'image' => 'image',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Không được để trống sản phẩm',
            'price.required' => 'Không được để trống giá',
            'price.integer' => 'Giá phải là số nguyên',
            'price.min' => 'Giá nhỏ nhất phải trên 1000',
            'promotion_price.min' => 'Giá khuyến mãi phải trên 999',
            'promotion_price.lt' => 'Giá khuyến mãi phải nhở hơn giá gốc',
            'promotion_end_date.date' => 'Ngày kết thúc phải được định dạng là ngày',
            'promotion_end_date.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày hiện tại',
            'quantity.required' => 'Không được để trống số lượng',
            'quantity.integer' => 'Số lượng phải là số nguyên',
            'quantity.min' => 'Số lượng nhỏ nhất phải trên 1',
            'image.image' => 'Vui lòng chọn file có định dạng là ảnh',
        ];
    }
}