<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    \App\Jobs\EchoOutput::dispatch(new DateTime());
    \Illuminate\Support\Facades\Log::error('Start Queue');
    return view('welcome');
});

Route::any('/jobs/', function(\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Log::error('Start Job');
    $job = new \App\Jobs\EchoOutput($request);
    $job->handle();
    return response()->json();
});
