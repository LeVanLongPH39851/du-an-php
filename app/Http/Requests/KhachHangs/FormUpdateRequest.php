<?php

namespace App\Http\Requests\KhachHangs;

use Illuminate\Validation\Rule;
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
        $userId = $this->route('khachhang');
        return [
            "name" => "required",
            "phone" => "required",
            "email" => [
               "required",
               "email",
               Rule::unique('users')->ignore($userId),
            ],
            "address" => "required",
            'image' => 'image',
            'password' => 'required|min:8'
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'Không được để trống tên khách hàng',
            'phone.required' => 'Không được để trống số điện thoại',
            'email.required' => 'Không được để trống email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã có người sử dụng',
            'address.required' => 'Không được để trống địa chỉ',
            'password.required' => 'Không được để trống mật khẩu',
            'password.min' => 'Mật khẩu phải có độ dài tối thiểu 8 ký tự',
            'image.image' => 'Vui lòng chọn file có định dạng là ảnh'
        ];
    }
}