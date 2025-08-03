<?php

namespace App\Observers\Form;

use App\Models\Form\Question;

class QuestionObserver
{
    public function creating(Question $question): void
    {
        if (!is_null($question->order)) return;

        $max = Question::query()
            ->where('form_id', $question->form_id)
            ->max('order');

        $question->order = is_null($max) ? 0 : $max + 1;
    }
}
