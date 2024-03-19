<?php

/**
 * @param string $number
 * @return int
 */
function parseStringToNumber(string $number): int{

    return intval(str_replace(array('.', ','), '', $number));
}

/**
 * @param string $number
 * @return string
 */
function parseNumberToString(string $number): string {

    $number = (float)$number;
    return number_format($number / 100, 2, ',', '.');
}

/**
 * @param string $date
 * @return string
 */
function convertDateFromString(string $date): string {

    return date('d-m-Y', strtotime($date));
}