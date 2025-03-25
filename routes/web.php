<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/add', function () {
    return ['data'=>\App\Jobs\ProcessDeduction::dispatch(new \App\Models\User(),['user_id'=>666,'balance'=>100])];
});
