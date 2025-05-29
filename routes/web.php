<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "teste";
});


Route::get('/teste', function () {
    return "Testeeeeeee";
});
