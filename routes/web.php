<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    \App\Jobs\EchoOutput::dispatch(new DateTime());
    \Illuminate\Support\Facades\Log::info('Before Welcome');
    return view('welcome');
});
