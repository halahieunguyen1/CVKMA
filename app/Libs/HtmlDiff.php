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
        // return highLightText($operations);
return $operations ;
}
function highLightText($operations) {
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
            $sentenceOrHtmlTag = $this->normalizeInHtmlSentence($sentenceOrHtmlTag);

            $sentenceSplitIntoWords = [];

            // This regex splits up every word by separating it at every non alpha-numerical, it allows the specialChars
            // in the middle of a word, but not at the beginning or the end of a word.
            // Split regex compiles to this (in default config case);
            // /\s|[\.\,\(\)\']|[a-zA-Z0-9\.\,\(\)'\pL]+[a-zA-Z0-9\pL]|[^\s]/mu
            $regex = sprintf('/\s|[%s]|[a-zA-Z0-9%s\pL]+[a-zA-Z0-9\pL]|[^\s]/mu', $specialCharacters, $specialCharacters);
            preg_match_all(
                $regex,
                $sentenceOrHtmlTag . ' ', // Inject a space at the end to make sure the last word is found by having a space behind it.
                $sentenceSplitIntoWords,
                PREG_SPLIT_NO_EMPTY
            );

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
}