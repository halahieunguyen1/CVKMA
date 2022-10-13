<!DOCTYPE html>
<html >
    
    <body class="antialiased">
        @php
        function highLightText($array, $positions) {
            $arrCard = ['a', 'div', 'i', 'span'];
            $arr = ['.', ',', '(', 's', ')'];
            $arr = ['s'];
            $text = '';
            $first = 0;
            $sttTu = 0;
            $specialCharacters = '[' . implode(',', $arrCard) . ']';
            $special = '(\\' . implode('|\\', $arr) . ')';
            foreach ($arrayIndex = $positions as $index) {
                $k = implode(array_slice($array, $index[0], $index[1] - $index[0]));
                if (!preg_match('/^'.$special.'*(<\/{0,1}'.$specialCharacters.'\.*>){0,1}'.$special.'*$/', $k)) {
                    $text .= implode(array_slice($array, $first, $index[0] - $first)) .'<span class="label diffmod" style="background-color:red; color: white;padding: 0 2px; font-size: 14px;">'.$k.'</span>';
                } else {
                    $text .= implode(array_slice($array, $first, $index[0] - $first)).$k;

                }
                $first = $index[1];
            }
            $text .=  implode(array_slice($array, $first));
            return $text;
        }
        @endphp
            {!! highLightText($old['text'], $old['position']) !!}
    </body>
</html>
