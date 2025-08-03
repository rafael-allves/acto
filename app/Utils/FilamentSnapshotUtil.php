<?php

namespace App\Utils;

use Exception;
use Illuminate\Support\Facades\Log;

final class FilamentSnapshotUtil
{
    /**
     * Normaliza um Snapshot do Filament removendo chaves de controle (ex: "s")
     * e promovendo as chaves "record-*" para o nível superior dos arrays.
     *
     * @param array $snapshot
     * @param bool $withTimeStamps
     * @return array Dados normalizados ou null em caso de erro
     */
    public static function getData(array $snapshot, bool $withTimeStamps = false): array
    {
        try {
            $data = ArrayUtil::promoteRecordKeys(
                ArrayUtil::removeArrayKey($snapshot['data']['data'], 's')
            );

            if ($withTimeStamps) return $data;

            return ArrayUtil::removeArrayKey(
                ArrayUtil::removeArrayKey(
                    $data,
                    'created_at'
                ),
                'updated_at'
            );
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            return [];
        }
    }
}
