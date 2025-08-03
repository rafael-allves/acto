<?php

namespace App\Observers\Form;

use App\Models\Form\Form;
use App\Utils\CompareUtil;
use App\Utils\FilamentSnapshotUtil;

class FormObserver
{
    public function creating(Form $form): void
    {
        if (auth()->check()) {
            $form->owner_id = auth()->id();
        }
    }

    public function saving(Form $form): void
    {
        $snapshot = json_decode(request()->components[0]['snapshot'], true);

        $cleanedSnapshot = FilamentSnapshotUtil::getData($snapshot);
        if(CompareUtil::deepCompare($cleanedSnapshot, $form->snapShot))return;
    }
}
