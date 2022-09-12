<?php
namespace App\Traits;
use ReflectionClass;

trait EnumTrait {
    public function getConstants() {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }
}