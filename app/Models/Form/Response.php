<?php

namespace App\Models\Form;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User $user
 * @property Form $form
 * @property int $form_id
 * @property int $user_id
 */
class Response extends Model
{
    protected $table = 'form_responses';

    protected $fillable = [
        'form_id',
        'user_id'
    ];

    public function form(): BelongsTo {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
