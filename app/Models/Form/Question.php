<?php

namespace App\Models\Form;

use App\Models\Form\Enums\QuestionType;
use App\Models\Traits\AutoOrdenable\AutoOrdenable;
use App\Models\Traits\AutoOrdenable\AutoOrdenableParent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Form $form
 * @property int $form_id
 * @property int $order
 * @property string $text
 * @property string $type
 * @property bool $mandatory
 */
class Question extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AutoOrdenable;
    use AutoOrdenableParent;

    protected $table = 'form_questions';

    protected $fillable = [
        'form_id',
        'order',
        'text',
        'type',
        'mandatory'
    ];

    protected $casts = [
        'mandatory' => 'boolean',
        'type' => QuestionType::class,
    ];

    protected function getOrdenableParentColumn(): string
    {
        return 'form_id';
    }

    protected function getOrdenableRelation(): string
    {
        return 'alternatives';
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function alternatives(): HasMany
    {
        return $this->hasMany(Alternative::class);
    }
}
