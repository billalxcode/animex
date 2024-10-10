<?php

function redirect_to($path) {
    header("location: $path");
    die();
}

function hide_string(string $string, string $chars = '*', int $length = 6, int $init = 3): string
{
    $getString  = $string;  // String yang akan disensor.
    $getChars   = $chars;   // Karakter yang akan digunakan.
    $getLength  = $length;  // Panjang karakter sensor.
    $getInit    = $init;    // Jumlah default karakter sensor.
    return substr_replace($getString, str_repeat($getChars, (strlen($getString) - $getLength)), $getInit, (strlen($getString) - $getLength));
}