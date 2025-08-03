<?php

namespace App\Models\Form;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property User $owner
 * @property int $owner_id
 * @property int $id
 * @property string $title
 * @property string $description
 * @property bool $is_active
 */
class Form extends Model
{
    use SoftDeletes;

    protected $table = 'forms';

    protected $fillable = [
        'owner_id',
        'title',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
