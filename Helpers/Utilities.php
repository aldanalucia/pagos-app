<?php

function parseStringToFloat(string $number): float {

    return floatval(str_replace([' ', ','], '', $number));
}

function parseFloatToString(string $number): string {

    return number_format($number, 2, ',', '.');
}

function convertDateFromString($date) {

    return date('d-m-Y', strtotime($date));
}