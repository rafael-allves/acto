<?php

use App\Livewire\Forms\AnswerForm;
use Illuminate\Support\Facades\Route;

Route::get('/forms/{form}/answer', AnswerForm::class)
    ->name('forms.answer');
