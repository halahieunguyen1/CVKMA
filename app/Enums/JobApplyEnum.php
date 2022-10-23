<?php

namespace App\Enums;

class JobApplyEnum extends AbstractEnum
{
    const RE_APPLY_WAIT_TIME = 600;
    const RE_APPLY_WAIT_TIME_STR = '10 phút';
    const STATUS_INIT = 0;
    const STATUS_VIEWED = 1;
    const STATUS_APPLY = 2;
    const STATUS_REFUSE = 3;

    const GET_JOB_CURRENT_APPLY = 0;
    const GET_ALL_JOB_APPLY = 1;
}
