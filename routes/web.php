<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    \App\Jobs\EchoOutput::dispatch(new DateTime());
    \Illuminate\Support\Facades\Log::info('Before Welcome');
    return view('welcome');
});

Route::any('/jobs/', function(\Illuminate\Support\Facades\Request $request) {
    $job = new \App\Jobs\EchoOutput($request);
    $job->handle();
});
