<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::any('category/create', [CategoryController::class, 'createCategory'])->name('createCategory');
Route::get('categories', [CategoryController::class, 'allCategories'])->name('allCategories');
Route::any('category/edit/{id}', [CategoryController::class, 'editCategory'])->name('editCategory');
Route::get('category/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');

// Route::delete('/deleteCategory/{id}', 'CategoryController@delete')->name('deleteCategory');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

