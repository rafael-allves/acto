<?php

use App\Livewire\Resources\Forms\Index;
use Illuminate\Support\Facades\Route;

Route::get('/', Index::class)->name('welcome');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
require __DIR__.'/forms.php';
