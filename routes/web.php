<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\back\AdminController;
use \App\Http\Controllers\back\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/home', [HomeController::class, 'index'])->name('home');


// ADMIN PANEL
Route::prefix('cms')->group(function () {

    //DAHBOARD
    Route::get('/', [AdminController::class, 'home'])->name('admin');

    //CATEGORY
    Route::get('/category', [CategoryController::class, 'categories'])->name('cat');
    Route::get('/add_category', [CategoryController::class, 'category_add'])->name('new_cat');
    Route::post('/add_category', [CategoryController::class, 'category_post'])->name('post_cat');
    Route::get('/category_edit/{id?}', [CategoryController::class, 'cat_edit'])->name('cat_edit');
    Route::post('/category_edit/{id?}', [CategoryController::class, 'cat_update'])->name('cat_edit_post');
    Route::get('/category_delete/{id?}', [CategoryController::class, 'cat_delete'])->name('cat_delete');
});


