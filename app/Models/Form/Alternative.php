<?php

namespace App\Models\Form;

use App\Scopes\OrderedScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Question $question
 * @property int $order
 * @property string $text
 * @property bool $is_correct
 */
class Alternative extends Model
{
    protected $table = "question_alternatives";

    protected $fillable = [
        'question_id',
        'order',
        'text',
        'is_correct'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    protected static function booted(): void {
        static::addGlobalScope(new OrderedScope);
    }

    public function question(): BelongsTo{
        return $this->belongsTo(Question::class);
    }
}
