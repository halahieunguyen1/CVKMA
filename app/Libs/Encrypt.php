<?php

namespace App\Libs;

use Caxy\HtmlDiff\HtmlDiff as Diff;

define('UNIQID_SALT', '9dbc3b83badaed8d9c1cd6fe89a3d751');// md5 CVMKA

class Encrypt
{
    public static function cvUniqueId() {
        return md5(uniqid(UNIQID_SALT, true));
    }
}