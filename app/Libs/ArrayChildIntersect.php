<?php

namespace App\Libs;

class ArrayChildIntersect
{

    public static function convertStringToArray(string $text) {
        $regex = '/\s|[a-zA-Z0-9%s\pL]+[a-zA-Z0-9\pL]|[^\s]/mu';
        preg_match_all($regex, $text, $array, PREG_SPLIT_NO_EMPTY);
        return $array[0];
    }

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

    public static function intersect1($arrayParent, $arrayIntersect, $action = 'delete') {
        $index = 0;
        $start = 0;
        $end = 0;
        if (!count($arrayParent)) {
            return [];
        }

        if (!count($arrayIntersect)) {
            return [
                [
                    $action => [
                        0, count($arrayParent)- 1,
                    ]
                ]
            ];
        }

        if ($arrayParent[0] == $arrayIntersect) {
            $flag = 'replace';
        } else {
            $flag = $action;
        }
        $countIntersect = count($arrayIntersect);
        $result = [
        ];
        foreach ($arrayParent as $key => $value) {
            if ($value == ($arrayIntersect[$index] ?? null)) {
                $index++;
                // if ($index >= $countIntersect) {
                //     continue;
                // }
                if ($flag != 'replace') {
                    $end = $key - 1;
                    $result[] = [
                        $action => [$start, $end],
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
                    $flag = $action;
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
                $action => [$start, $end],
            ];
        }

        return self::highlightText($arrayParent, $result, $action);
    }

    public static function highlightText($arrayText, $operations, $classCss = 'delete')
    {
        $result = '';
        foreach ($operations as $value) {
            if (isset($value['replace'])) {
                $offset = $value['replace'];
                if ($offset[1] > 0) {
                    $result .= implode(' ', array_slice($arrayText, $offset[0], $offset[1]- $offset[0] + 1)) . ' ';
                }
            }

            if (isset($value[$classCss])) {
                $offset = $value[$classCss];
                if ($offset[1] > 0) {
                    $result .= "<span class='$classCss'>" .implode(' ', array_slice($arrayText, $offset[0], $offset[1]- $offset[0] + 1)) . '</span> ';
                }
            }
        }
        return  $result;
    }
}