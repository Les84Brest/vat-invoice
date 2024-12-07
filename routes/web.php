<?php

use Illuminate\Support\Facades\Route;

$getVueTemplate = function () {
    return view('vue');
};


Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome', $getVueTemplate);

Auth::routes();

