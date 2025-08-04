<?php

namespace App\Observers\Form;

use App\Models\Form\Form;

class FormObserver
{
    public function creating(Form $form): void
    {
        if (auth()->check()) {
            $form->owner_id = auth()->id();
        }
    }
}
