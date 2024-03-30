<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    \App\Jobs\EchoOutput::dispatch(new DateTime());
    \Illuminate\Support\Facades\Log::error('Before Welcome');
    return view('welcome');
});

Route::any('/jobs/', function(\Illuminate\Support\Facades\Request $request) {
    \Illuminate\Support\Facades\Log::error('Jobs', ['request' => $request->all()]);
    $job = new \App\Jobs\EchoOutput($request);
    $job->handle();
    return response()->json([])->status(200);
});
