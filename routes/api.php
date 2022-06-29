<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/byDate/{date}', [ApiController::class, 'getByDate']);
Route::get('/byNumber/{number}', [ApiController::class, 'getByNumber']);
