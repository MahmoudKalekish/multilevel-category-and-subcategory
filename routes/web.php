<?php

use App\Http\Controllers\CategoryController;
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

// Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
// Route::post('/categories', 'CategoryController@store')->name('categories.store');
// Route::post('/subcategories', 'SubcategoryController@index')->name('subcategories');

// Route::resource('category', 'CategoryController');




Route::get('/', function () {
    return view('welcome');
});
