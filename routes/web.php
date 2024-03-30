<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    \App\Jobs\EchoOutput::dispatch(new DateTime());
    $user = \App\Models\User::first();
    return view('welcome', ['user' => $user]);
});
