<?php

namespace App\Models\Form\Enums;

enum QuestionType: string
{
    case MultipleChoice = 'multiple_choice';
    case Open = 'open';
}
