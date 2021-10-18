<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\back\AdminController;
use \App\Http\Controllers\back\CategoryController;
use \App\Http\Controllers\back\LessonController;
use \App\Http\Controllers\back\TestQuestionController;
use \App\Http\Controllers\back\TestAnswerController;

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
    // SYSTEM DAHBOARD
    Route::prefix('/system')->group(function () {

        //CATEGORY
        Route::get('/category', [CategoryController::class, 'categories'])->name('cat');
        Route::get('/add_category', [CategoryController::class, 'category_add'])->name('new_cat');
        Route::post('/add_category', [CategoryController::class, 'category_post'])->name('post_cat');
        Route::get('/category_edit/{id?}', [CategoryController::class, 'cat_edit'])->name('cat_edit');
        Route::post('/category_edit/{id?}', [CategoryController::class, 'cat_update'])->name('cat_edit_post');
        Route::get('/category_trashed', [CategoryController::class, 'cat_trashed'])->name('cat_trashed');
        Route::get('/category_delete/{id?}', [CategoryController::class, 'cat_delete'])->name('cat_delete');
        Route::get('/category_restore/{id?}', [CategoryController::class, 'cat_restore'])->name('cat_restore');
        Route::get('/category_destroy/{id?}', [CategoryController::class, 'cat_destroy'])->name('cat_destroy');
        Route::delete('/category_alldelete', [CategoryController::class, 'cat_alldelete'])->name('cat_all_delete');
        Route::delete('/category_trashed_delete', [CategoryController::class, 'cat_trashed_delete'])->name('cat_trashed_delete');

        // LESSONS
        Route::get('/lesson', [LessonController::class, 'lessons'])->name('lesson');
        Route::get('/add_lesson', [LessonController::class, 'lesson_add'])->name('new_lesson');
        Route::post('/add_lesson', [LessonController::class, 'lesson_post'])->name('post_lesson');
        Route::get('/lesson_edit/{id?}', [LessonController::class, 'lesson_edit'])->name('lesson_edit');
        Route::post('/lesson_edit/{id?}', [LessonController::class, 'lesson_update'])->name('lesson_edit_post');
        Route::get('/lesson_trashed', [LessonController::class, 'lesson_trashed'])->name('lesson_trashed');
        Route::get('/lesson_delete/{id?}', [LessonController::class, 'lesson_delete'])->name('lesson_delete');
        Route::get('/lesson_restore/{id?}', [LessonController::class, 'lesson_restore'])->name('lesson_restore');
        Route::get('/lesson_destroy/{id?}', [LessonController::class, 'lesson_destroy'])->name('lesson_destroy');
        Route::delete('/lesson_alldelete', [LessonController::class, 'lesson_alldelete'])->name('lesson_all_delete');
        Route::delete('/lesson_trashed_delete', [LessonController::class, 'lesson_trashed_delete'])->name('lesson_trashed_delete');

        // TEST QUESTION
        Route::get('/test_question', [TestQuestionController::class, 'test_question'])->name('test_question');
        Route::get('/add_test_question', [TestQuestionController::class, 'test_question_add'])->name('new_test_question');
        Route::post('/add_test_question', [TestQuestionController::class, 'test_question_post'])->name('post_test_question');
        Route::get('/test_question_edit/{id?}', [TestQuestionController::class, 'test_question_edit'])->name('test_question_edit');
        Route::post('/test_question_edit/{id?}', [TestQuestionController::class, 'test_question_update'])->name('test_question_edit_post');
        Route::get('/test_question_trashed', [TestQuestionController::class, 'test_question_trashed'])->name('test_question_trashed');
        Route::get('/test_question_delete/{id?}', [TestQuestionController::class, 'test_question_delete'])->name('test_question_delete');
        Route::get('/test_question_restore/{id?}', [TestQuestionController::class, 'test_question_restore'])->name('test_question_restore');
        Route::get('/test_question_destroy/{id?}', [TestQuestionController::class, 'test_question_destroy'])->name('test_question_destroy');
        Route::delete('/test_question_alldelete', [TestQuestionController::class, 'test_question_alldelete'])->name('test_question_all_delete');
        Route::delete('/test_question_trashed_delete', [TestQuestionController::class, 'test_question_trashed_delete'])->name('test_question_trashed_delete');

        // TEST ANSWERS
        Route::get('/test_answer', [TestAnswerController::class, 'test_answer'])->name('test_answers');
        Route::get('/add_test_answer', [TestAnswerController::class, 'test_answer_add'])->name('new_test_answer');
        Route::post('/add_test_answer', [TestAnswerController::class, 'test_answer_post'])->name('post_test_answer');
        Route::get('/test_answer_edit/{id?}', [TestAnswerController::class, 'test_answer_edit'])->name('test_answer_edit');
        Route::post('/test_answer_edit/{id?}', [TestAnswerController::class, 'test_answer_update'])->name('test_answer_edit_post');
        Route::get('/test_answer_trashed', [TestAnswerController::class, 'test_answer_trashed'])->name('test_answer_trashed');
        Route::get('/test_answer_delete/{id?}', [TestAnswerController::class, 'test_answer_delete'])->name('test_answer_delete');
        Route::get('/test_answer_restore/{id?}', [TestAnswerController::class, 'test_answer_restore'])->name('test_answer_restore');
        Route::get('/test_answer_destroy/{id?}', [TestAnswernController::class, 'test_answer_destroy'])->name('test_answer_destroy');
        Route::delete('/test_answer_alldelete', [TestAnswerController::class, 'test_answer_alldelete'])->name('test_answer_all_delete');
        Route::delete('/test_answer_trashed_delete', [TestAnswerController::class, 'test_answer_trashed_delete'])->name('test_answer_trashed_delete');
    });
});


