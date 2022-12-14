<?php

namespace App\Http\Requests\Cv;
use App\Http\Requests\BaseRequest;

class UpdateCvRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'global' => ['required'],
            'cv_id' => ['required'],
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
            '*.required' => ':attribute kh??ng ???????c ????? tr???ng!',
            '*.*.required' => ':attribute kh??ng ???????c ????? tr???ng!',
            '*.*.*.required' => ':attribute kh??ng ???????c ????? tr???ng!',
            '*.*.max' => ':attribute kh??ng ???????c qu?? :max k?? t???!',
            '*.*.*.max' => ':attribute kh??ng ???????c qu?? :max k?? t???!',
            '*.email'=>'Ph???i l?? email',
            'profile.regex'=>'Ph???i l?? s??? ??i???n tho???i',
            
        ];
    }

    public function attributes()
    {
        return [
            'global' => 'Ti??u ?????',
            'cv_id' => 'CV',
            'profile' => 'Th??ng tin c?? nh??n',
            'profile.phone' => 'S??? ??i???n tho???i',
            'profile.email' => 'Email',
            'profile.address' => '?????a ch???',
            'profile.fullname' => 'H??? t??n',
            'education' => 'H???c v???n',
            'education.*.start' => 'Th???i gian b???t ?????u h???c',
            'education.*.end' => 'Th???i gian k???t th??c h???c',
            'education.*.school' => 'T??n tr?????ng',
            'education.*.description' => 'M?? t??? tr?????ng',
            'education.*.majors' => 'Chuy??n ngh??nh',
            'experience' => 'Kinh nghi???m',
            'experience.*.start' => 'Th???i gian b???t ?????u l??m',
            'experience.*.end' => 'Th???i gian k???t th??c l??m',
            'experience.*.company' => 'T??n c??ng ty',
            'experience.*.position' => 'T??n v??? tr??',
            'experience.*.description' => 'M?? t??? kinh nghi???m',
            'activity' => 'Ho???t ?????ng',
            'activity.*.start' => 'Th???i gian b???t ?????u ho???t ?????ng',
            'activity.*.end' => 'Th???i gian k???t th??c ho???t ?????ng',
            'activity.*.organization' => 'T??n t??? ch???c',
            'activity.*.position' => 'T??n v??? tr??',
            'activity.*.description' => 'M?? t??? ho???t ?????ng',
            'certification' => 'Ch???ng ch???',
            'certification.*.start' => 'Th???i gian nh???n ch???ng ch???',
            'certification.*.name' => 'T??n ch???ng ch???',
            'award' => 'Ph???n ph?????ng',
            'award.*.start' => 'Th???i gian nh???n ph???n th?????ng',
            'award.*.name' => 'T??n ph???n th?????ng',
            'skillrate' => 'K?? n??ng',
            'skillrate.*.title' => 'T??n k?? n??ng',
            'skillrate.*.description' => 'M?? t??? k?? n??ng',
        ];
    }
}
