<?php

use App\Livewire\Resources\Forms\{
    Response,
    ViewResponse,
    Index
};
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('forms')->as('forms.')->group(function () {
    Route::get('/', Index::class)->name('index');

    Route::prefix('{form}')->group(function () {
        Route::get('answer', Response::class)->name('answer');
        Route::get('answered', Response::class)->name('answered');

        Route::prefix('answers')->as('answers.')->group(function () {
            Route::get('{answer}', ViewResponse::class)->name('show');
        });
    });
});
