<?php

namespace App\Http\Requests\User;

use Auth;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'max:30',
            'last_name' => 'max:30',
            'phone' => ['regex:/^0[0-9]{9}$/', Rule::unique('users','phone')->ignore(Auth::id())],
            'address' => 'max:200',
            'dob' => ['date', 'before:today'],
            'exp' => 'numeric|max:127'
        ];
    }

    public function messages()
    {
        return [
            'first_name.max' => ':attribute không được quá 30 kí tự',
            'last_name.max' => ':attribute không được quá 30 kí tự',
            'phone.regex' => ':attribute không đúng định dạng',
            'phone.unique' => ':attribute đã tồn tại',
            'dob.date' => ':attribute không đúng định dạng',
            'dob.before' => ':attribute phải là ngày trong quá khứ',
            'address.max' => ':attribute không được quá 200 kí tự',
            'exp.numeric' => ':attribute sai định dạng',
            'exp.max' => ':attribute vượt quá giới hạn cho phép',
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'Họ đệm',
            'last_name' => 'Tên',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'dob' => 'Ngày sinh',
            'exp' => 'Kinh nghiệm',
        ];
    }

}
