<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShowController;

Route::get('/', [ProductController::class, 'index']);

Route::resource('products', ProductController::class);
Route::resource('customers', CustomerController::class);

