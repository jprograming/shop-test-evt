<?php

namespace App\Util;

/**
 * Class that contains string operations.
 * @package App\Util
 */
class UtilString
{

    /**
     * Returns the value given in money format
     * @param float|null $value
     * @param int $decimals
     * @return string
     */
    public static function getMoneyFormatOrEmpty(?float $value, int $decimals = 2): string
    {
        return (!is_null($value)) ? '$'.number_format($value, $decimals) : "";
    }

}