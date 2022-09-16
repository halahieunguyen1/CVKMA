<?php

namespace App\Enums\Response;
use App\Enums\AbstractEnum;

class StatusCode extends AbstractEnum
{
    const FAIL_VALIDATE = 402;
    const TYPE_PREMIUM = 1;

    const STATUS_OK = 0;
    const STATUS_BAN = 1;
    const STATUS_TRASH = 2;

    const FIND_JOB_ON = 0;
    const FIND_JOB_OFF = 1;

}
