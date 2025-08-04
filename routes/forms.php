<?php

use App\Livewire\Resources\Forms\{
    Index,
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
