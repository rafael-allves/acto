<?php

namespace App\Utils;

final class ArrayUtil
{
    /**
     * Remove recursivamente uma chave de um array, incluindo estruturas que contenham apenas essa chave.
     *
     * Exemplo:
     *   - Entrada: ['foo' => ['s' => 'arr'], 'bar' => 'baz'] com $keyToRemove = 's'
     *   - Saída: ['bar' => 'baz']
     *
     * @param array $data O array de entrada.
     * @param string $keyToRemove A chave que será removida.
     * @return array O array resultante sem a chave especificada.
     */
    public static function removeArrayKey(
        array  $data,
        string $keyToRemove,
    ): array {
        $cleaned = [];

        foreach ($data as $key => $value) {
            if (is_array($value) && count($value) === 1 && isset($value[$keyToRemove])) continue;

            if ($key === $keyToRemove) continue;

            if (is_array($value)) {
                $value = self::removeArrayKey($value, $keyToRemove);
            }

            $cleaned[$key] = $value;
        }

        return $cleaned;
    }
}
