<?php

namespace App\Models\Traits\Snapshotable;

use App\Models\Snapshot;
use App\Utils\CompareUtil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait Snapshotable
 *
 * Esta trait adiciona suporte a "snapshots" (versões históricas de um modelo) de forma automática
 * utilizando relacionamento polimórfico com o model {@see Snapshot}.
 *
 * Ao salvar um modelo que utilize esta trait, um novo snapshot será registrado automaticamente,
 * caso o estado atual do modelo tenha mudado em relação ao último snapshot persistido.
 *
 * Para funcionar corretamente, o model que usa esta trait deve implementar o método abstrato
 * {@see self::buildSnapshot()}, que deve retornar um array representando o estado atual do modelo.
 *
 * ### Exemplo de uso no Model:
 * ```php
 * class Form extends Model {
 *     use Snapshotable;
 *
 *     protected function buildSnapshot(): array
 *     {
 *         return $this->loadMissing(['questions.alternatives'])->toArray();
 *     }
 * }
 * ```
 *
 * @mixin Model
 */
trait Snapshotable
{
    /**
     * Registra o evento "saving" para gerar e armazenar um snapshot automático.
     *
     * Este método é chamado automaticamente pelo Eloquent quando o model é inicializado.
     * Ele compara o snapshot atual com o último armazenado e salva um novo apenas se houver mudanças.
     *
     * @return void
     */
    protected static function bootSnapshotable(): void
    {
        static::saving(function (self $model): void {
            $snapshot = $model->buildSnapshot();

            if (CompareUtil::deepCompare($snapshot, $model->currentSnapshot()->data)) return;

            $model->snapshot($snapshot);
        });
    }

    /**
     * Método que deve ser implementado pelo model para gerar o snapshot atual.
     *
     * Ele deve retornar um array representando o estado completo do modelo e suas relações relevantes.
     *
     * @return array
     */
    abstract protected function buildSnapshot(): array;

    /**
     * Retorna a relação polimórfica "morphMany" com o model Snapshot.
     *
     * Exemplo: $form->snapshots
     *
     * @return MorphMany
     */
    public function snapshots(): MorphMany
    {
        return $this->morphMany(Snapshot::class, 'snapshotable');
    }

    /**
     * Cria e salva um novo snapshot com os dados fornecidos.
     *
     * @param array $snapshot Array representando o estado atual do modelo.
     * @return void
     */
    public function snapshot(array $snapshot): void
    {
        $this->snapshots()->create([
            'data' => $snapshot,
        ]);
    }

    /**
     * Retorna o snapshot mais recente registrado no banco de dados.
     *
     * @return Snapshot|null Retorna null caso não haja snapshots anteriores.
     */
    public function currentSnapshot(): ?Snapshot
    {
        return $this->snapshots()
            ->latest()
            ->first();
    }
}
