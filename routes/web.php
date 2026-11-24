<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/admin/dashboard', 'admin.dashboard')
    ->name('admin.dashboard');

Route::view('/carrito', 'tienda.carrito')
    ->name('carrito.demo');    

Route::view('/checkout', 'tienda.checkout')
    ->name('checkout.demo');

Route::view('/home-3d-demo', 'tienda.home-3d-demo')
    ->name('home.3d.demo');
    
Route::view('/home', 'tienda.home')
    ->name('home');    