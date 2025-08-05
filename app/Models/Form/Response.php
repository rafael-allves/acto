<?php

namespace App\Models\Form;

use App\Models\Snapshot;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User $user
 * @property Form $form
 * @property int $form_id
 * @property int $user_id
 * @property Snapshot $formSnapshot
 * @property array $response
 * @property DateTime $created_at
 * @property int $id
 */
class Response extends Model
{
    protected $table = 'form_responses';

    protected $fillable = [
        'form_id',
        'user_id',
        'snapshot_id',
        'response'
    ];

    protected $casts = [
        'response' => 'array',
        'created_at' => 'datetime',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function formSnapshot(): BelongsTo{
        return $this->belongsTo(Snapshot::class, 'snapshot_id');
    }
}
