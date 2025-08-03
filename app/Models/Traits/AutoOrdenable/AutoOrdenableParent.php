<?php

namespace App\Models\Traits\AutoOrdenable;


trait AutoOrdenableParent
{
    public static function bootAutoOrdenableParent(): void
    {
        static::saved(function ($model) {
            $relationName = $model->getOrdenableRelation();
            $model->loadMissing($relationName);

            /** @var \Illuminate\Database\Eloquent\Collection $currentItems */
            $currentItems = $model->getRelation($relationName);

            $idsRecebidos = $currentItems->pluck('id')->filter()->all();

            $idsNoBanco = $model->{$relationName}()
                ->withoutGlobalScopes()
                ->pluck('id')
                ->all();

            $idsParaExcluir = array_diff($idsNoBanco, $idsRecebidos);

            if (!empty($idsParaExcluir)) {
                $model->{$relationName}()
                    ->whereIn('id', $idsParaExcluir)
                    ->delete();
            }
        });
    }

    protected abstract function getOrdenableRelation(): string;
}
