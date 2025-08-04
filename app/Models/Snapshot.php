<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property array $data
 * @property int $id
 */
class Snapshot extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'data'
    ];

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime',
    ];

    public function snapshotable(): MorphTo
    {
        return $this->morphTo();
    }
}
