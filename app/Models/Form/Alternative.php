<?php

namespace App\Models\Form;

use App\Models\Traits\AutoOrdenable\AutoOrdenable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Question $question
 * @property int $order
 * @property string $text
 * @property bool $is_correct
 */
class Alternative extends Model
{
    use SoftDeletes;
    use AutoOrdenable;

    protected $table = "form_question_alternatives";

    protected $fillable = [
        'question_id',
        'order',
        'text',
        'is_correct'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    protected function getOrdenableParentColumn(): string
    {
        return 'question_id';
    }

    public function question(): BelongsTo{
        return $this->belongsTo(Question::class);
    }
}
