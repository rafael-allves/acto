<?php

namespace App\Models\Form;

use App\Models\User;
use App\Observers\Form\FormObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property User $owner
 * @property int $owner_id
 * @property int $id
 * @property string $title
 * @property string $description
 * @property bool $is_active
 * @property Question $questions
 */
#[ObservedBy(FormObserver::class)]
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

    public function questions(): HasMany {
        return $this->hasMany(Question::class, 'form_id');
    }
}
