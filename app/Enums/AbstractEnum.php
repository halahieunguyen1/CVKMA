<?php

namespace App\Enums;

use ReflectionClass;

abstract class AbstractEnum
{
    public static function getConstants(): array
    {
        return (new ReflectionClass(__CLASS__))->getConstants();
    }

    public static function getValue(string $key)
    {
        return static::getConstants()[$key];
    }
}
