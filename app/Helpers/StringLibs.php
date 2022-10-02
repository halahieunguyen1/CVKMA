<?php

function separateFullName(
    string $fullName
) {
    $names = explode(' ', trim($fullName));
    return [array_pop($names), implode(' ', $names)];
}

function separateFullNameHasId(
    string $fullName
) {
    $names = explode(' ', trim($fullName));
    return [array_pop($names) . ' ' . array_pop($names), implode(' ', $names)];
}
