<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    $viewData = [];
    $viewData["title"] = "Home Page - Tienda Online";
    return view('home.index')->with("viewData", $viewData);
});

Route::get('/productos', function () {
    return view('productos');
});

Route::get('/about', 'App\Http\Controllers\HomeController@about')->name("home.about");
