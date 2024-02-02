<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();

});

// Product Controller

Route::get("/data", [ProductController:: class, 'getData']);

Route::get("/types", [ProductController:: class, 'getTypes']);

Route::get("/subtypes", [ProductController:: class, 'getSubtypes']);

Route::get("/products", [ProductController:: class, 'getProducts']);

Route::get("/subproducts", [ProductController:: class, 'getSubproducts']);

Route::get("/sales", [ProductController:: class, 'getSales']);

Route::post("/salesById", [ProductController:: class, 'getSalesById']);

// Login Controller

Route::post("/register", [UserController:: class, 'register']);

Route::post("/authenticate", [UserController:: class, 'authenticate']);

Route::post("/isAuthenticated", [UserController:: class, 'isAuthenticated']);

Route::get("/user", [UserController:: class, 'user']);

Route::get("/logout", [UserController:: class, 'logout']);//-> middleware('auth');
