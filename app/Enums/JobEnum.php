<?php

namespace App\Enums;

class JobEnum extends AbstractEnum
{
    const SALARY_TYPE_VND = 0;
    const SALARY_TYPE_USD = 1;

    const PUBLISH_ON = 1;
    const PUBLISH_OFF = 0;

    const JOB_POSITION =  [
        1 => 'Nhân viên',
        2 => 'Trưởng nhóm',
        3 => 'Trưởng/Phó phòng',
        10 => 'Quản lý / Giám sát',
        20 => 'Trưởng chi nhánh',
        25 => 'Phó giám đốc',
        30 => 'Giám đốc',
        50 => 'Thực tập sinh',
    ];

}
