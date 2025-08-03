<?php

namespace App\Models\Traits;

use App\Models\Snapshot;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait Snapshotable
 *
 * Permite que qualquer modelo armazene "snapshots" (versões do estado atual) usando relação polimórfica.
 *
 */
trait Snapshotable
{
    /**
     * Define a relação polimórfica com o modelo Snapshot.
     *
     * @return MorphMany
     */
    public function snapshots(): MorphMany
    {
        return $this->morphMany(Snapshot::class, 'snapshotable');
    }

    /**
     * Cria um novo snapshot com os dados fornecidos.
     *
     * @param array $snapshot
     * @return void
     */
    public function snapshot(array $snapshot): void
    {
        $this->snapshots()->create([
            'data' => $snapshot,
        ]);
    }

    /**
     * Retorna o último snapshot registrado, ou null se não houver nenhum.
     *
     * @return array|null
     */
    public function currentSnapshot(): ?array
    {
        return $this->snapshots()->latest()->value('data');
    }
}
