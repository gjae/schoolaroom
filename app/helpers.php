<?php

use Illuminate\Support\Str;

/**
 * Return string on uppercase and cleaned of blank spaces
 *
 * @param string $str
 * @return string
 */
function trimAndUpper(string $str) 
{
    return (string) Str::of($str)->trim()->upper();
}