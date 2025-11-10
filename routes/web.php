<?php

use Illuminate\Support\Facades\Route;

// Importar todos os Controllers usados nas rotas
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\OrderController; // CORRIGIDO: Usando OrderController
use App\Http\Controllers\ShowController; // Deixei seu controller aqui, caso use

// Rota principal
Route::get('/', [ProductController::class, 'index']);

// ROTAS DE RECURSO
Route::resource('products', ProductController::class);
Route::resource('customers', CustomerController::class);

// ROTAS FALTANTES PARA O MENU: CATEGORIAS E PEDIDOS
Route::resource('categories', CategoryController::class);
Route::resource('orders', OrderController::class); // CORRIGIDO: Usando OrderController

