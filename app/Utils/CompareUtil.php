<?php

namespace App\Utils;

final class CompareUtil
{
    /**
     * Compara profundamente duas estruturas (arrays, objetos simples, valores escalares).
     *
     * - Considera listas (arrays com chaves numéricas sequenciais) e arrays associativos.
     * - Retorna false se houver qualquer diferença estrutural ou de valores.
     *
     * @param mixed $a
     * @param mixed $b
     * @return bool
     */
    public static function deepCompare(mixed $a, mixed $b): bool
    {
        if (gettype($a) !== gettype($b)) {
            return false;
        }

        if (is_array($a)) {
            if (count($a) !== count($b)) {
                return false;
            }
            if (array_is_list($a) && array_is_list($b)) {

                foreach ($a as $index => $value) {
                    if (!self::deepCompare($value, $b[$index])) {
                        return false;
                    }
                }

                return true;
            }

            foreach ($a as $key => $value) {
                if (!array_key_exists($key, $b)) {
                    return false;
                }

                if (!self::deepCompare($value, $b[$key])) {
                    return false;
                }
            }

            return true;
        }

        return $a === $b;
    }
}
