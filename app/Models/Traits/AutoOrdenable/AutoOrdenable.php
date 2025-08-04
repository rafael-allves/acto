<?php

namespace App\Models\Traits\AutoOrdenable;

use Illuminate\Database\Eloquent\Builder;

trait AutoOrdenable
{
    public const SCOPE_NAME = 'ordenable';

    protected static function bootAutoOrdenable(): void
    {
        static::addGlobalScope(self::SCOPE_NAME, function (Builder $builder) {
            $builder->orderBy($builder->getModel()->getOrderColumn(), $builder->getModel()->getOrderDirection());
        });

        static::creating(function ($model) {
            if (! is_null($model->getAttribute($model->getOrderColumn()))) {
                return;
            }

            $relationColumn = $model->getOrdenableParentColumn();
            $relationValue = $model->getAttribute($relationColumn);

            $max = $model->newQuery()
                ->where($relationColumn, $relationValue)
                ->max($model->getOrderColumn());

            $model->setAttribute(
                $model->getOrderColumn(),
                is_null($max) ? 0 : $max + 1
            );
        });
    }

    protected abstract function getOrdenableParentColumn(): string;

    protected function getOrderColumn(): string
    {
        return 'order';
    }

    protected function getOrderDirection(): string
    {
        return 'asc';
    }
}
