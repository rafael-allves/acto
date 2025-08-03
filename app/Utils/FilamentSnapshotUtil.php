<?php

namespace App\Utils;

use Exception;
use Illuminate\Support\Facades\Log;

final class FilamentSnapshotUtil
{
    /**
     * Normaliza um snapshot do Filament removendo chaves de controle (ex: "s")
     * e promovendo as chaves "record-*" para o nível superior dos arrays.
     *
     * @param array $snapShot
     * @return array Dados normalizados ou null em caso de erro
     */
    public static function getData(array $snapShot): array
    {
        try {
            return ArrayUtil::promoteRecordKeys(
                ArrayUtil::removeArrayKey($snapShot, 's')
            );
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
            return [];
        }
    }
}
