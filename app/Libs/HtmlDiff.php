<?php

namespace App\Libs;

use Caxy\HtmlDiff\HtmlDiff as Diff;

class HtmlDiff extends Diff
{
    public static function created($oldText, $newText, HtmlDiffConfig $config = null)
    {
        $diff = new self($oldText, $newText);

        if (null !== $config) {
            $diff->setConfig($config);
        }

        return $diff;
    }

    public function build()
    {
        //Thanh lọc text, loại bỏ js,...
        // $this->prepare();

        if ($this->oldText == $this->newText) {
            return $this->newText;
        }

        $this->splitInputsToWords();
        $this->replaceIsolatedDiffTags();
        $this->indexNewWords();

        $operations = $this->operations();
        return $this->highLightText($operations);
}
    private function highLightText($operations) {
    $arrayOld = $this->oldWords;
    $arrayNew = $this->newWords;
    $textOld = '';
    $textNew = '';
    $firstOld = 0;
    $firstNew = 0;
    $sttTu = 0;
    
    foreach ($arrayIndex = $operations as $value) {
        $kOld = implode(array_slice($arrayOld, $value->startInOld, $value->endInOld - $value->startInOld));
        $kNew = implode(array_slice($arrayNew, $value->startInNew, $value->endInNew - $value->startInNew));
        $textOld .= implode(array_slice($arrayOld, $firstOld, $value->startInOld - $firstOld));
        $textNew .= implode(array_slice($arrayNew, $firstNew, $value->startInNew - $firstNew));
         if ($value->action == 'delete')
        {
            $textOld .= $this->highLight($kOld);
        }

        if ($value->action == 'replace')
        {
            $textOld .= $this->highLight($kOld);
            $textNew .= $this->highLight($kNew);
        }
        if ($value->action == 'insert' ) {
            $textNew .= $this->highLight($kNew);
        }
        if ($value->action == 'equal') {
            $textOld .= $kOld;
            $textNew .= $kNew;

        }

        $firstOld = $value->endInOld;
        $firstNew = $value->endInNew;
    }
    $textOld .=  implode(array_slice($arrayOld, $firstOld));
    $textNew .=  implode(array_slice($arrayNew, $firstNew));
    return compact('textOld', 'textNew');
}
public function getOldWords() {
    return $this->oldWords;
}

public function getNewWords() {
    return $this->newWords;
}
protected function convertHtmlToListOfWords(string $text) : array
    {
        $words            = [];
        $sentencesAndTags = [];

        $specialCharacters = '';

        foreach ($this->config->getSpecialCaseChars() as $char) {
            $specialCharacters .= '\\' . $char;
        }

        // Normalize no-break-spaces to regular spaces
        $text = str_replace("\xc2\xa0", ' ', $text);
        preg_match_all('/<.+?>|[^<]+/mu', $text, $sentencesAndTags, PREG_SPLIT_NO_EMPTY);
        foreach ($sentencesAndTags[0] as $sentenceOrHtmlTag) {
            if ($sentenceOrHtmlTag === '') {
                continue;
            }
            
            if ($sentenceOrHtmlTag[0] === '<') {
                $words[] = $sentenceOrHtmlTag;
                
                continue;
            }
            // $sentenceOrHtmlTag = $this->normalizeWhitespaceInHtmlSentence($sentenceOrHtmlTag);
            // $sentenceOrHtmlTag = $this->normalizeInHtmlSentence($sentenceOrHtmlTag);

            $sentenceSplitIntoWords = [];

            // This regex splits up every word by separating it at every non alpha-numerical, it allows the specialChars
            // in the middle of a word, but not at the beginning or the end of a word.
            // Split regex compiles to this (in default config case);
            // /\s|[\.\,\(\)\']|[a-zA-Z0-9\.\,\(\)'\pL]+[a-zA-Z0-9\pL]|[^\s]/mu
            $regex = sprintf('/[%s]+|[a-zA-Z0-9\pL]+[a-zA-Z0-9\pL]|[^\s]/mu', $specialCharacters);
            // dd($regex);
            preg_match_all(
                $regex,
                $sentenceOrHtmlTag . ' ', // Inject a space at the end to make sure the last word is found by having a space behind it.
                $sentenceSplitIntoWords,
                PREG_SPLIT_NO_EMPTY
            );
// dd($sentenceSplitIntoWords);
            // Remove the last space, since that was added by us for the regex matcher
            array_pop($sentenceSplitIntoWords[0]);

            foreach ($sentenceSplitIntoWords[0] as $word) {
                $words[] = $word;
            }
        }
        return $words;
    }

    protected function normalizeInHtmlSentence(string $sentence) : string
    {
        if ($this->config->isKeepNewLines() === true) {
            return $sentence;
        }

        // $sentence = preg_replace('/\s\s+|\r+|\n+|\r\n+/', ' ', $sentence);
        $sentence = preg_replace('/[\s|\r|\n|\r\n|\.|\(|\)|\,]+/', ' ', $sentence);


        $sentenceLength = $this->stringUtil->strlen($sentence);
        $firstCharacter = $this->stringUtil->substr($sentence, 0, 1);
        $lastCharacter  = $this->stringUtil->substr($sentence, $sentenceLength -1, 1);

        if ($firstCharacter === ' ' || $firstCharacter === "\r" || $firstCharacter === "\n") {
            $sentence = ' ' . ltrim($sentence);
        }

        if ($sentenceLength > 1 && ($lastCharacter === ' ' || $lastCharacter === "\r" || $lastCharacter === "\n")) {
            $sentence = rtrim($sentence) . ' ';
        }

        return $sentence;
    }

    public function highLight($text) {
        $arr = ['.', ',', '(', 's', ')'];
        $arrCard = ['a', 'div', 'i', 'span'];
        $specialCharacters = '[' . implode(',', $arrCard) . ']';
        $special = '(\\' . implode('|\\', $arr) . ')';
        if (!preg_match('/^'.$special.'*(<\/{0,1}'.$specialCharacters.'\.*>){0,1}'.$special.'*$/', $text)) {
            return '<span class="high-light">'.$text.'</span>';
        }
        return $text;
    }
}