<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/admin/dashboard', 'admin.dashboard')
    ->name('admin.dashboard');

Route::view('/carrito', 'tienda.carrito')
    ->name('carrito.demo');    