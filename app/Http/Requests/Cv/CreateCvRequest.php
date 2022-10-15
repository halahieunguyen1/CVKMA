<?php

namespace App\Http\Requests\Cv;
use App\Http\Requests\BaseRequest;

class CreateCvRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'profile' => ['required'],
            'profile.phone' => 'required', 'regex:/^0[0-9]{9}$/',
            'profile.email' => 'required', 'email',
            'profile.address' => 'required', 'max: 100',
            'profile.fullname' => 'required', 'max: 100',
            'education' =>'array',
            'education.*.start' =>'required|max: 20',
            'education.*.end' =>'required|max: 20',
            'education.*.school' =>'required|max: 256',
            'education.*.description' =>'required|max: 1000',
            'education.*.majors' =>'required|max: 256',
            'experience' =>'array',
            'experience.*.start' =>'required|max: 20',
            'experience.*.end' =>'required|max: 20',
            'experience.*.company' =>'required|max: 256',
            'experience.*.position' =>'required|max: 256',
            'experience.*.description' =>'required|max: 1000',
            'activity' =>'array',
            'activity.*.start' =>'required|max: 20',
            'activity.*.end' =>'required|max: 20',
            'activity.*.organization' =>'required|max: 256',
            'activity.*.position' =>'required|max: 256',
            'activity.*.description' =>'required|max: 1000',
            'certification' =>'array',
            'certification.*.start' =>'required|max: 100',
            'certification.*.name' =>'required|max: 256',
            'award' =>'array',
            'award.*.start' =>'required|max: 100',
            'award.*.name' =>'required|max: 256',
            'skillrate' =>'array',
            'skillrate.*.title' =>'required|max: 100',
            'skillrate.*.description' =>'required|max: 256',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => ':attribute không được để trống!',
            '*.*.required' => ':attribute không được để trống!',
            '*.*.*.required' => ':attribute không được để trống!',
            '*.*.max' => ':attribute không được quá :max kí tự!',
            '*.*.*.max' => ':attribute không được quá :max kí tự!',
            '*.email'=>'Phải là email',
            'profile.regex'=>'Phải là số điện thoại',
            
        ];
    }

    public function attributes()
    {
        return [
            'profile' => 'Thông tin cá nhân',
            'profile.phone' => 'Số điện thoại',
            'profile.email' => 'Email',
            'profile.address' => 'Địa chỉ',
            'profile.fullname' => 'Họ tên',
            'education' => 'Học vấn',
            'education.*.start' => 'Thời gian bắt đầu học',
            'education.*.end' => 'Thời gian kết thúc học',
            'education.*.school' => 'Tên trường',
            'education.*.description' => 'Mô tả trường',
            'education.*.majors' => 'Chuyên nghành',
            'experience' => 'Kinh nghiệm',
            'experience.*.start' => 'Thời gian bắt đầu làm',
            'experience.*.end' => 'Thời gian kết thúc làm',
            'experience.*.company' => 'Tên công ty',
            'experience.*.position' => 'Tên vị trí',
            'experience.*.description' => 'Mô tả kinh nghiệm',
            'activity' => 'Hoạt động',
            'activity.*.start' => 'Thời gian bắt đầu hoạt động',
            'activity.*.end' => 'Thời gian kết thúc hoạt động',
            'activity.*.organization' => 'Tên tổ chức',
            'activity.*.position' => 'Tên vị trí',
            'activity.*.description' => 'Mô tả hoạt động',
            'certification' => 'Chứng chỉ',
            'certification.*.start' => 'Thời gian nhận chứng chỉ',
            'certification.*.name' => 'Tên chứng chỉ',
            'award' => 'Phần phưởng',
            'award.*.start' => 'Thời gian nhận phần thưởng',
            'award.*.name' => 'Tên phần thưởng',
            'skillrate' => 'Kĩ năng',
            'skillrate.*.title' => 'Tên kĩ năng',
            'skillrate.*.description' => 'Mô tả kĩ năng',
        ];
    }
}
