<?php

namespace App\Helpers;

/**
 * Classe de funções úteis relacionadas à arrays
 * @package App\Helpers
 */
class ArrayHelper
{
    /**
     * Verifica se o array possui alguma chave string
     *
     * @param array $arr
     * @return bool
     */
    public static function isAssoc(array $arr)
    {
        if ([] === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
