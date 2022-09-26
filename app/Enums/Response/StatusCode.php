<?php

namespace App\Enums\Response;
use App\Enums\AbstractEnum;

class StatusCode extends AbstractEnum
{
    const FAIL_VALIDATE = 402;
    const FAIL_AUTHENTICATE = 422;

}
