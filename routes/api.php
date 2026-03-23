<?php

use App\Http\Controllers\Api\BlogAutomationController;
use Illuminate\Support\Facades\Route;

Route::post('internal/blog-automation', [BlogAutomationController::class, 'store'])
    ->middleware(['n8n.blog', 'throttle:30,1']);
