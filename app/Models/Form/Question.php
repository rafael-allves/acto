<?php

namespace App\Models\Form;

use App\Models\Form\Enums\QuestionType;
use App\Scopes\OrderedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Form $form
 * @property int $form_id
 * @property int $order
 * @property string $text
 * @property string $type
 * @property bool $is_active
 */
class Question extends Model
{
    use SoftDeletes;

    protected $table = 'form_questions';

    protected $fillable = [
        'form_id',
        'order',
        'text',
        'type',
        'is_active'
    ];

    protected static function booted(): void {
        static::addGlobalScope(new OrderedScope);
    }

    protected $casts = [
        'is_active' => 'boolean',
        'type' => QuestionType::class,
    ];

    public function form(): BelongsTo{
        return $this->belongsTo(Form::class);
    }
}
