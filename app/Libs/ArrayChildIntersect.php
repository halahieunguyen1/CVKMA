<?php

namespace App\Libs;

class ArrayChildIntersect
{
    public static function intersect($arrayOne, $arrayTwo) {
        $countOne = count($arrayOne);
        $countTwo = count($arrayTwo);
        $intersect = array_fill(0, $countOne + 1, array_fill(0, $countTwo + 1, [
            'length' => 0,
            'value' => [],
        ]));
        foreach ($arrayOne as $key1 => $value1) {
            foreach ($arrayTwo as $key2 => $value2) {
                if ($value1 == $value2) {
                    $intersect[$key1 + 1][$key2 + 1] = [
                        'length' => $intersect[$key1][$key2]['length'] + 1,
                        'value' => array_merge($intersect[$key1][$key2]['value'], [$value1])
                    ];
                } else {
                    $intersect[$key1 + 1][$key2 + 1] = [
                        'length' => max($intersect[$key1][$key2 + 1]['length'], $intersect[$key1 + 1][$key2]['length']),
                        'value' => ($intersect[$key1][$key2 + 1]['length'] == max($intersect[$key1][$key2 + 1]['length'], $intersect[$key1 + 1][$key2]['length'])) ? $intersect[$key1][$key2 + 1]['value'] : $intersect[$key1 + 1][$key2]['value'],
                    ];  
                }
            }
        }
        return $intersect[$countOne][$countTwo];
    }

    public static function intersect1($arrayParent, $arrayIntersect, $key1 = 'delete') {
        $index = 0;
        $start = 0;
        $end = 0;
        if (!count($arrayParent)) {
            return [];
        }

        if (!count($arrayIntersect)) {
            return [
                [
                    'delete' => [
                        0, count($arrayParent)- 1,
                    ]
                ]
            ];
        }

        if ($arrayParent[0] == $arrayIntersect) {
            $flag = 'replace';
        } else {
            $flag = $key1;
        }
        $countIntersect = count($arrayIntersect);
        $result = [
        ];
        dump(count($arrayParent));
        foreach ($arrayParent as $key => $value) {
            if ($value == ($arrayIntersect[$index] ?? null)) {
                $index++;
                // if ($index >= $countIntersect) {
                //     continue;
                // }
                if ($flag != 'replace') {
                    $end = $key - 1;
                    $result[] = [
                        $key1 => [$start, $end],
                    ];
                    $start = $key;
                    $flag = 'replace';
                }
            } else {
                if ($flag == 'replace') {
                    $end = $key - 1;
                    $result[] = [
                        'replace' => [$start, $end],
                    ];
                    $start = $key;
                    $flag = $key1;
                }
            }
        }
        $end = $key;
        if ($flag == 'replace') {
            $result[] = [
                'replace' => [$start, $end],
            ];
        } else {
            $result[] = [
                $key1 => [$start, $end],
            ];
        }
        
        dd($result);
    }
}