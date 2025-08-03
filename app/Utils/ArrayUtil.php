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

    /**
     * Promove chaves que comecem com "record-" para o nível superior do array.
     *
     * Exemplo:
     *   - Entrada: ['questions' => [['record-1' => ['id' => 1]]]]
     *   - Saída: ['questions' => [['id' => 1]]]
     *
     * @param array $data O array de entrada.
     * @return array O array com as chaves "record-*" promovidas.
     */
    public static function promoteRecordKeys(array $data): array
    {
        $cleaned = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = self::promoteRecordKeys($value);

                if (count($value) === 1) {
                    $firstKey = array_key_first($value);

                    if (str_starts_with($firstKey, 'record-')) {
                        $value = $value[$firstKey];
                    }
                }
            }

            if (is_array($value) && array_is_list($value)) {
                $value = array_map(function ($item) {
                    return self::promoteRecordKeys($item);
                }, $value);
            }

            $cleaned[$key] = $value;
        }

        return $cleaned;
    }
}
