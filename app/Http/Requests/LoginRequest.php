<?php

namespace App\Http\Requests;

use App\Enums\AuthEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use App\Enums\Response\StatusCode;
use Illuminate\Http\Request;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        $table = match ($request->type_auth) {
            AuthEnum::TYPE_ADMIN => 'admins',
            AuthEnum::TYPE_EMPLOYER => 'employers',
            default => 'users',
        };
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

    protected function failedValidation(Validator $validator)
    {

        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(
            [
                'error' => $errors,
                'status_code' => StatusCode::FAIL_VALIDATE,
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
