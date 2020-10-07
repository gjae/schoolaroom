<?php

use Illuminate\Support\Str;
use Carbon\Carbon;

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

/**
 * Return true if $time is between $betweenInit and $betweenEnd
 *
 * @param string $time
 * @param string $betweenInit
 * @param string $betweenEnd
 * @return boolean
 */
function timeBetweenOr(
    string $time, 
    string $betweenInit, 
    string $betweenEnd
) :bool {

    $itTime = Carbon::createFromTimeString($time);
    $start = Carbon::createFromTimeString($betweenInit);
    $end = Carbon::createFromTimeString($betweenEnd);

    return ($itTime->gt($start) || $itTime->gt($end));
}

function timeBetweenAnd(
string $time, 
string $betweenInit, 
string $betweenEnd
) :bool {

    $itTime = Carbon::createFromTimeString($time);
    $start = Carbon::createFromTimeString($betweenInit);
    $end = Carbon::createFromTimeString($betweenEnd);

    return $itTime->between($start, $end);
}