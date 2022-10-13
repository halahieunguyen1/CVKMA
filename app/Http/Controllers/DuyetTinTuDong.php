<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as Request;
use App\Libs\HtmlDiff;
use App\Libs\HtmlDiffConfig;

class DuyetTinTuDong extends Controller
{
    public function diff(Request $request) {
        

 
    $oldHtml = "Chuyên......            Viên Tư Vấn Tài Chính_ Làm Việc Tại SHINHAN Hà Nội (Chi Nhánh Mới)_Thu Nhập Từ <i>11 Triệu</i>";
    $newHtml = "Chuyên Viên Tư Vấn Tài Chính_ Làm Việc Tại SEABANK Đại Từ_Thu Nhập Từ 480Usd
    Địa điểm	Hà Nội	 <a>11 Triệu</a>";
    $data = $this->diffHtml($oldHtml, $newHtml);
        return view('diff', $data);
    }
    
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateRandomStringTotal($length = 10) {
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $this->generateRandomString(10) . ' ';
    }
    return $randomString;
}

function diffHtml ($oldHtml , $newHtml) {
    $config = new HtmlDiffConfig();
    $config
    ->setInsertSpaceInReplace(true)
    ->setMatchThreshold(95)
    ->setSpecialCaseChars([])
    ;
    $config ->setIsolatedDiffTags([])
;
    // Create an HtmlDiff object with the custom configuration.
    $htmlDiff = HtmlDiff::created($oldHtml, $newHtml, $config);

    $diff = $htmlDiff->build();
    $old = [];
    $new = [];
    if (is_array($diff)) {
        foreach ($diff as $value) {
            if ($value->action == 'delete' || $value->action == 'replace' )
            $old[] = [$value->startInOld, $value->endInOld];
            if ($value->action == 'insert' )
            $new[] = [$value->startInNew, $value->endInNew];
        }
        return [
            'old' => [
                'position' => $old,
                'text' => $htmlDiff->getOldWords()
            ],
            'new' => [
                'position' => $new,
                'text' => $htmlDiff->getNewWords()
            ]
        ];
    } else
    return [
        'old' => [
            'text' => $oldHtml
        ],
        'new' => [
            'text' => $oldHtml
        ]
    ];
 }



}
