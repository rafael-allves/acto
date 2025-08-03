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

    public function saved(Form $form): void {
        $form->loadMissing('questions');

        $idsRecebidos = $form->questions->pluck('id')->all();
        $idsNoBanco = $form->questions()->withoutGlobalScopes()->pluck('id')->all();
        $idsParaExcluir = array_diff($idsNoBanco, $idsRecebidos);

        if (!empty($idsParaExcluir)) {
            $form->questions()->whereIn('id', $idsParaExcluir)->delete();
        }
    }
}
