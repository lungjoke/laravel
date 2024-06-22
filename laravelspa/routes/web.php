<?php

use Illuminate\Support\Facades\Route;

Route::get('/{{any?}}', function () {
    return view('welcome');
})->where('any','^(?!apiV)[V\w\.-]*');
