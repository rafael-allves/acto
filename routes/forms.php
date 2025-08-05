<?php

use App\Filament\Pages\SubmitForm;
use App\Filament\Pages\ViewFormResponse;
use App\Livewire\Resources\Forms\{
    Show,
    Response\Show as ResponseShow
};
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('forms')->as('forms.')->group(function () {
    Route::prefix('{form}')->group(function () {
        Route::get('/', Show::class)->name('show');
        Route::prefix('responses')->as('responses.')->group(function () {
            Route::get('{response}', ResponseShow::class)->name('show');
        });
    });
});


Route::middleware(['web', 'auth'])->prefix('filament/app/forms')->as('filament.app.pages.')->group(function () {
    Route::get('{form}/submit', SubmitForm::class)->name('submit-form');
    Route::get('{form}/responses/{response}', ViewFormResponse::class)->name('view-form-response');
});
