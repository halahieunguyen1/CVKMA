<?php

namespace App\Http\Requests\Auth;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use App\Enums\Response\StatusCode;

class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required_without:phone', 'email'],
            'password' => 'required',
            'phone' => ['required_without:email', 'regex:/^0[0-9]{9}$/'],
        ];
    }

    public function messages()
    {
        return [
            'email.required_without' => ':attribute không được để trống!',
            'email.email' => ':attribute không đúng định dạng',
            'password.required' => ':attribute không được để trống!',
            'phone.required_without' => ':attribute không được để trống',
            'phone.regex' => ':attribute không đúng định dạng',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email hoặc số điện thoại',
            'password' => 'Mật khẩu',
            'phone' => 'Email hoặc số điện thoại',
        ];
    }
}
