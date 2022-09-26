<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use App\Enums\Response\StatusCode;

class ChangePasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'password' => 'required',
            'new_password' => 'required|min:6|max:30|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => ':attribute không được để trống!',
            'new_password.min' => ':attribute tối thiểu phải là 6 kí tự',
            'new_password.required' => ':attribute không được để trống!',
            'new_password.confirmed' => ':attribute nhập lại không chính xác',
        ];
    }

    public function attributes()
    {
        return [
            'password' => 'Mật khẩu',
            'new_password' => 'Mật khẩu mới',
        ];
    }
}
