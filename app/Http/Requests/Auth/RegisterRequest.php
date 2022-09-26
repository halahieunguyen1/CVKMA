<?php

namespace App\Http\Requests\Auth;

use App\Enums\AuthEnum;
use App\Models\User;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use App\Enums\Response\StatusCode;
use Illuminate\Http\Request;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        return [
            'email' => ['required', 'email', Rule::unique('users','email')],
            'password' => 'required|min:6|max:30|confirmed',
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'phone' => ['required', 'regex:/^0[0-9]{9}$/', Rule::unique('users','phone')],
            'address' => 'required',
            'dob' => ['required', 'date', 'before:today'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ':attribute không được để trống!',
            'email.email' => ':attribute không đúng định dạng',
            'email.unique' => ':attribute đã tồn tại',
            'password.required' => ':attribute không được để trống!',
            'password.min' => ':attribute phải tối thiểu 6 kí tự',
            'password.max' => ':attribute không được quá 30 kí tự',
            'password.confirmed' => ':attribute nhập lại không chính xác',
            'first_name.required' => ':attribute không được để trống',
            'first_name.max' => ':attribute không được quá 30 kí tự',
            'last_name.required' => ':attribute không được để trống',
            'last_name.max' => ':attribute không được quá 30 kí tự',
            'phone.required' => ':attribute không được để trống',
            'phone.regex' => ':attribute không đúng định dạng',
            'phone.unique' => ':attribute đã tồn tại',
            'address.required' => ':attribute không được để trống',
            'dob.required' => ':attribute không được để trống',
            'dob.date' => ':attribute không đúng định dạng',
            'dob.before' => ':attribute phải là ngày trong quá khứ',

        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'first_name' => 'Họ đệm',
            'last_name' => 'Tên',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'dob' => 'Ngày sinh',
        ];
    }

}
