<?php

namespace App\Enums;

class CompanyEnum extends AbstractEnum
{
    const SIZE_VERY_SMALL = 0;
    const SIZE_SMALL = 1;
    const SIZE_MEDIUM = 2;
    const SIZE_LARGE = 3;
    const SIZE_VERY_LARGE = 4;

    const SIZE_VERY_SMALL_STR = '0-50';
    const SIZE_SMALL_STR = '50-100';
    const SIZE_MEDIUM_STR = '100-500';
    const SIZE_LARGE_STR = '500-1000';
    const SIZE_VERY_LARGE_STR = '>1000';


}
