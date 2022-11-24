<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\back\RegisterController;
use \App\Http\Controllers\back\LoginController;
use \App\Http\Controllers\back\AdminController;
use \App\Http\Controllers\back\UserController;
use \App\Http\Controllers\back\CategoryController;
use \App\Http\Controllers\back\LessonController;
use \App\Http\Controllers\back\TestQuestionController;
use \App\Http\Controllers\back\TestAnswerController;
use \App\Http\Controllers\back\CarCategoryController;
use \App\Http\Controllers\back\ExamQuestionController;
use \App\Http\Controllers\back\ExamAnswerController;
use \App\Http\Controllers\back\GroupController;
use \App\Http\Controllers\back\GroupUserController;
use \App\Http\Controllers\back\JurnalController;
use \App\Http\Controllers\back\ReportController;
use \App\Http\Controllers\back\TestReportController;
use \App\Http\Controllers\back\KursController;
use \App\Http\Controllers\back\KursCategoryController;
use \App\Http\Controllers\back\KursLessonController;
use \App\Http\Controllers\back\KursQuestionController;
use \App\Http\Controllers\back\KursUserController;
use \App\Http\Controllers\front\StudentRegisterController;
use \App\Http\Controllers\front\StudentLoginController;
use \App\Http\Controllers\front\BalanceController;
use \App\Http\Controllers\front\ExamController;
use \App\Http\Controllers\front\FrontKursController;
use \App\Http\Controllers\front\MesajController;
use \App\Http\Controllers\front\CommentsController;

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

// STUDENT USER

Route::get('/student_register', [StudentRegisterController::class, 'register'])->name('studentregister');
Route::post('/studentregister', [StudentRegisterController::class, 'studentregister'])->name('student_register');
Route::get('/student_login', [StudentLoginController::class, 'login'])->middleware('isStudentLogin')->name('studentlogin');
Route::post('/studentlogin', [StudentLoginController::class, 'studentlogin'])->middleware('isStudentLogin')->name('student_login');
//Route::get('/', [HomeController::class, 'index'])->name('home');
//Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/profile', [StudentLoginController::class, 'profile'])->middleware('isStudentAdmin')->name('profile');
Route::get('/profile/question/{id?}', [StudentLoginController::class, 'user_question'])->middleware('isStudentAdmin')->name('profile.question');
//Route::get('/profile_edit/{id?}', [StudentLoginController::class, 'edit'])->middleware('isStudentAdmin')->name('profile.edit');
Route::post('/post_profile_edit/{id?}', [StudentLoginController::class, 'edit_post'])->middleware('isStudentAdmin')->name('post.edit.profile');
Route::get('/home', [HomeController::class, 'index'])->middleware('isStudentAdmin')->name('home');
Route::get('/home/share', [HomeController::class, 'shares'])->middleware('isStudentAdmin')->name('home.share');
Route::get('/balance', [BalanceController::class, 'balance'])->middleware('isStudentAdmin')->name('balance');
Route::get('/payment', [BalanceController::class, 'payment'])->middleware('isStudentAdmin')->name('payment');
Route::post('/amount', [BalanceController::class, 'amount'])->middleware('isStudentAdmin')->name('post_amount');
Route::get('/exam', [ExamController::class, 'exam'])->middleware('isStudentAdmin')->name('exam');
Route::post('/exam', [ExamController::class, 'exam_post'])->middleware('isStudentAdmin')->name('exam_post');
Route::get('/course', [FrontKursController::class, 'kurs'])->middleware('isStudentAdmin')->name('course');
Route::get('/question', [ExamController::class, 'question'])->middleware('isStudentAdmin')->name('question');
Route::get('/cat/{slug?}', [HomeController::class, 'category'])->middleware('isStudentAdmin')->name('category');
Route::get('/lesson/{slug?}', [HomeController::class, 'lesson'])->middleware('isStudentAdmin')->name('single_lesson');
Route::post('/share', [HomeController::class, 'share'])->middleware('isStudentAdmin')->name('post_share');
Route::get('/shares', [HomeController::class, 'shares'])->middleware('isStudentAdmin')->name('shares');
Route::get('/share/{id?}', [StudentLoginController::class, 'share'])->middleware('isStudentAdmin')->name('share');
Route::put('/share_edit/{id?}', [StudentLoginController::class, 'share_edit_post'])->middleware('isStudentAdmin')->name('share.edit.post');
Route::get('/share_delete/{id?}', [StudentLoginController::class, 'share_delete'])->middleware('isStudentAdmin')->name('share.delete');
Route::get('/share_photo_delete/{id?}', [StudentLoginController::class, 'share_photo_delete'])->middleware('isStudentAdmin')->name('share.photo.delete');
Route::post('/share_for_comment', [CommentsController::class, 'share_for_comment'])->middleware('isStudentAdmin')->name('share.comment.post');
Route::get('/mesajs', [MesajController::class, 'sms'])->middleware('isStudentAdmin')->name('sms');
Route::get('/mesaj_user/{id?}', [MesajController::class, 'sms_user'])->middleware('isStudentAdmin')->name('sms.user');
Route::post('/post_mesaj', [MesajController::class, 'post_sms'])->middleware('isStudentAdmin')->name('post.mesaj');
Route::get('/mesaj_edit/{id?}', [MesajController::class, 'sms_edit'])->middleware('isStudentAdmin')->name('sms.edit');
Route::post('/mesaj_edit_post/{id?}', [MesajController::class, 'sms_edit_post'])->middleware('isStudentAdmin')->name('sms.edit.post');
Route::get('/mesaj_delete/{id?}', [MesajController::class, 'sms_delete'])->middleware('isStudentAdmin')->name('sms.delete');

Route::get('/test/{id?}', [HomeController::class, 'test'])->middleware('isStudentAdmin')->name('tests');
Route::post('/test', [HomeController::class, 'test_user'])->middleware('isStudentAdmin')->name('test_user');
Route::get('/studentlogout', [StudentLoginController::class, 'exit'])->middleware('isStudentAdmin')->name('exit');


// ADMIN PANEL
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/user_register', [RegisterController::class, 'userregister'])->name('user_register');
Route::get('/login', [LoginController::class, 'login'])->middleware('isLogin')->name('login');
Route::post('/user_login', [LoginController::class, 'userlogin'])->middleware('isLogin')->name('user_login');
Route::prefix('cms')->middleware('isAdmin')->group(function () {
    
    //DAHBOARD
    Route::get('/', [AdminController::class, 'home'])->name('admin');
    Route::get('/admins', [AdminController::class, 'admins'])->name('admins');// alinmadi
    Route::get('/admin_edit/{id?}', [AdminController::class, 'admin_edit'])->name('adminedit');
    Route::post('/admin_edit_post/{id?}', [AdminController::class, 'admin_edit_post'])->name('admineditpost');
    Route::get('/admins_edit/{id?}', [AdminController::class, 'admins_edit'])->name('admins_edit');
    Route::post('/admins_edit_post/{id?}', [AdminController::class, 'admins_edit_post'])->name('admins_edit_post');
    // HESABAT
    Route::get('/reports', [ReportController::class, 'reports'])->name('reports');
    // USER REPORTS
    Route::get('/test_reports', [TestReportController::class, 'user_reports'])->name('user.reports');
    // TEST REPORTS
    Route::get('/user_reports/test_reports', [TestReportController::class, 'test_reports'])->name('test.reports');
    Route::get('/user_reports/test_report_user', [TestReportController::class, 'test_report_user'])->name('test.report.users');

    Route::get('/user_reports/test_kurs_reports', [TestReportController::class, 'test_kurs_reports'])->name('test.kurs.reports');
    Route::get('/user_reports/kurs_question_look/{id?}', [TestReportController::class, 'kurs_question_look'])->name('kurs.question.look');

  //Route::get('/groups', [GroupController::class, 'groups'])->name('groups');

  // KURS

  Route::prefix('/kurs')->group(function () {
    Route::get('/', [KursController::class, 'kurs'])->name('kurs');
    Route::get('/new_kurs', [KursController::class, 'kurs_add'])->name('new.kurs');
    Route::post('/new_kurs_post', [KursController::class, 'kurs_insert'])->name('post_kurs');
    Route::get('/edit_kurs/{id?}', [KursController::class, 'kurs_edit'])->name('kurs.edit');
    Route::post('/edit_kurs_post/{id?}', [KursController::class, 'kurs_update'])->name('kurs_edit_post');

    //KURS CATEGORY
    Route::get('/kurs_category', [KursCategoryController::class, 'kurscategories'])->name('kurs_cat');
    Route::get('/kurs_add_category', [KursCategoryController::class, 'kurscategory_add'])->name('kurs.new_cat');
    Route::post('/kurs_add_category', [KursCategoryController::class, 'kurscategory_post'])->name('kurs.post_cat');
    Route::get('/kurs_category_edit/{id?}', [KursCategoryController::class, 'kurscat_edit'])->name('kurs.cat_edit');
    Route::post('/kurs_category_edit/{id?}', [KursCategoryController::class, 'kurscat_update'])->name('kurs.cat_edit_post');
    Route::get('/kurs_category_trashed', [KursCategoryController::class, 'kurscat_trashed'])->name('kurs.cat_trashed');
    Route::get('/kurs_category_delete/{id?}', [KursCategoryController::class, 'kurscat_delete'])->name('kurs.cat_delete');
    Route::get('/kurs_category_restore/{id?}', [KursCategoryController::class, 'kurscat_restore'])->name('kurs.cat_restore');
    Route::get('/kurs_category_destroy/{id?}', [KursCategoryController::class, 'kurscat_destroy'])->name('kurs.cat_destroy');
    Route::delete('/kurs_category_alldelete', [KursCategoryController::class, 'kurscat_alldelete'])->name('kurs.cat_all_delete');
    Route::delete('/kurs_category_trashed_delete', [KursCategoryController::class, 'kurscat_trashed_delete'])->name('kurs.cat_trashed_delete');

    // KURS LESSONS
    Route::get('/kurs_lesson', [KursLessonController::class, 'kurs_lessons'])->name('kurs_lesson');
    Route::get('/kurs_add_lesson', [KursLessonController::class, 'kurs_lesson_add'])->name('kurs_new_lesson');
    Route::post('/kurs_add_lesson', [KursLessonController::class, 'kurs_lesson_post'])->name('kurs_post_lesson');
    Route::get('/kurs_lesson_edit/{id?}', [KursLessonController::class, 'kurs_lesson_edit'])->name('kurs_lesson_edit');
    Route::post('/kurs_lesson_edit/{id?}', [KursLessonController::class, 'kurs_lesson_update'])->name('kurs_lesson_edit_post');
    Route::get('/kurs_lesson_trashed', [KursLessonController::class, 'kurs_lesson_trashed'])->name('kurs_lesson_trashed');
    Route::get('/kurs_lesson_delete/{id?}', [KursLessonController::class, 'kurs_lesson_delete'])->name('kurs_lesson_delete');
    Route::get('/kurs_lesson_restore/{id?}', [KursLessonController::class, 'kurs_lesson_restore'])->name('kurs_lesson_restore');
    Route::get('/kurs_lesson_destroy/{id?}', [KursLessonController::class, 'kurs_lesson_destroy'])->name('kurs_lesson_destroy');
    Route::delete('/kurs_lesson_alldelete', [KursLessonController::class, 'kurs_lesson_alldelete'])->name('kurs_lesson_all_delete');
    Route::delete('/kurs_lesson_trashed_delete', [KursLessonController::class, 'kurs_lesson_trashed_delete'])->name('kurs_lesson_trashed_delete');

    // KURS QUESTION
    Route::get('/kurs_question', [KursQuestionController::class, 'kurs_question'])->name('kurs_question');
    Route::get('/add_kurs_question', [KursQuestionController::class, 'kurs_question_add'])->name('new_kurs_question');
    Route::post('/add_kurs_question', [KursQuestionController::class, 'kurs_question_post'])->name('post_kurs_question');
    Route::get('/kurs_question_edit/{id?}', [KursQuestionController::class, 'kurs_question_edit'])->name('kurs_question_edit');
    Route::post('/kurs_question_edit/{id?}', [KursQuestionController::class, 'kurs_question_update'])->name('kurs_question_edit_post');
    Route::get('/kurs_question_trashed', [KursQuestionController::class, 'kurs_question_trashed'])->name('kurs_question_trashed');
    Route::get('/kurs_question_delete/{id?}', [KursQuestionController::class, 'kurs_question_delete'])->name('kurs_question_delete');
    Route::get('/kurs_question_restore/{id?}', [KursQuestionController::class, 'kurs_question_restore'])->name('kurs_question_restore');
    Route::get('/kurs_question_destroy/{id?}', [KursQuestionController::class, 'kurs_question_destroy'])->name('kurs_question_destroy');
    Route::delete('/kurs_question_alldelete', [KursQuestionController::class, 'kurs_question_alldelete'])->name('kurs_question_all_delete');
    Route::delete('/kurs_question_trashed_delete', [KursQuestionController::class, 'kurs_question_trashed_delete'])->name('kurs_question_trashed_delete');

    // KURS USER PAYMENT
    Route::get('/kurs_user', [KursUserController::class, 'kurs_user'])->name('kurs.user');
  });
    
    // SYSTEM DAHBOARD
    Route::prefix('/system')->group(function () {

        //USERS

        Route::get('/users', [UserController::class, 'users'])->name('users');
        Route::get('/users_edit/{id?}', [UserController::class, 'users_edit'])->name('users_edit');
        Route::post('/users_edit_post/{id?}', [UserController::class, 'users_edit_post'])->name('users_edit_post');

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
        Route::get('/test_answer_destroy/{id?}', [TestAnswerController::class, 'test_answer_destroy'])->name('test_answer_destroy');
        Route::delete('/test_answer_alldelete', [TestAnswerController::class, 'test_answer_alldelete'])->name('test_answer_all_delete');
        Route::delete('/test_answer_trashed_delete', [TestAnswerController::class, 'test_answer_trashed_delete'])->name('test_answer_trashed_delete');

        // CAR CATEGORY
        Route::get('/car_category', [CarCategoryController::class, 'car_categories'])->name('car_cat');
        Route::get('/add_car_category', [CarCategoryController::class, 'car_category_add'])->name('new_car_cat');
        Route::post('/add_car_category', [CarCategoryController::class, 'car_category_post'])->name('post_car_cat');
        Route::get('/car_category_edit/{id?}', [CarCategoryController::class, 'car_cat_edit'])->name('car_cat_edit');
        Route::post('/car_category_edit/{id?}', [CarCategoryController::class, 'car_cat_update'])->name('car_cat_edit_post');
        Route::get('/car_category_trashed', [CarCategoryController::class, 'car_cat_trashed'])->name('car_cat_trashed');
        Route::get('/car_category_delete/{id?}', [CarCategoryController::class, 'car_cat_delete'])->name('car_cat_delete');
        Route::get('/car_category_restore/{id?}', [CarCategoryController::class, 'car_cat_restore'])->name('car_cat_restore');
        Route::get('/car_category_destroy/{id?}', [CarCategoryController::class, 'car_cat_destroy'])->name('car_cat_destroy');
        Route::delete('/car_category_alldelete', [CarCategoryController::class, 'car_cat_alldelete'])->name('car_cat_all_delete');
        Route::delete('/car_category_trashed_delete', [CarCategoryController::class, 'car_cat_trashed_delete'])->name('car_cat_trashed_delete');

        // EXAM QUESTION
        Route::get('/exam_question', [ExamQuestionController::class, 'exam_question'])->name('exam_question');
        Route::get('/add_exam_question', [ExamQuestionController::class, 'exam_question_add'])->name('new_exam_question');
        Route::post('/add_exam_question', [ExamQuestionController::class, 'exam_question_post'])->name('post_exam_question');
        Route::get('/exam_question_edit/{id?}', [ExamQuestionController::class, 'exam_question_edit'])->name('exam_question_edit');
        Route::post('/exam_question_edit/{id?}', [ExamQuestionController::class, 'exam_question_update'])->name('exam_question_edit_post');
        Route::get('/exam_question_trashed', [ExamQuestionController::class, 'exam_question_trashed'])->name('exam_question_trashed');
        Route::get('/exam_question_delete/{id?}', [ExamQuestionController::class, 'exam_question_delete'])->name('exam_question_delete');
        Route::get('/exam_question_restore/{id?}', [ExamQuestionController::class, 'exam_question_restore'])->name('exam_question_restore');
        Route::get('/exam_question_destroy/{id?}', [ExamQuestionController::class, 'exam_question_destroy'])->name('exam_question_destroy');
        Route::delete('/exam_question_alldelete', [ExamQuestionController::class, 'exam_question_alldelete'])->name('exam_question_all_delete');
        Route::delete('/exam_question_trashed_delete', [ExamQuestionController::class, 'exam_question_trashed_delete'])->name('exam_question_trashed_delete');

        // EXAM ANSWERS
        Route::get('/exam_answer', [ExamAnswerController::class, 'exam_answer'])->name('exam_answers');
        Route::get('/add_exam_answer', [ExamAnswerController::class, 'exam_answer_add'])->name('new_exam_answer');
        Route::post('/add_exam_answer', [ExamAnswerController::class, 'exam_answer_post'])->name('post_exam_answer');
        Route::get('/exam_answer_edit/{id?}', [ExamAnswerController::class, 'exam_answer_edit'])->name('exam_answer_edit');
        Route::post('/exam_answer_edit/{id?}', [ExamAnswerController::class, 'exam_answer_update'])->name('exam_answer_edit_post');
        Route::get('/exam_answer_trashed', [ExamAnswerController::class, 'exam_answer_trashed'])->name('exam_answer_trashed');
        Route::get('/exam_answer_delete/{id?}', [ExamAnswerController::class, 'exam_answer_delete'])->name('exam_answer_delete');
        Route::get('/exam_answer_restore/{id?}', [ExamAnswerController::class, 'exam_answer_restore'])->name('exam_answer_restore');
        Route::get('/exam_answer_destroy/{id?}', [ExamAnswerController::class, 'exam_answer_destroy'])->name('exam_answer_destroy');
        Route::delete('/exam_answer_alldelete', [ExamAnswerController::class, 'exam_answer_alldelete'])->name('exam_answer_all_delete');
        Route::delete('/exam_answer_trashed_delete', [ExamAnswerController::class, 'exam_answer_trashed_delete'])->name('exam_answer_trashed_delete');

        // GROUPS
        Route::get('/groups', [GroupController::class, 'groups'])->name('groups');
        Route::get('/add_group', [GroupController::class, 'group_add'])->name('new_group');
        Route::post('/add_group_post', [GroupController::class, 'group_post'])->name('post_group');
        Route::get('/group_edit/{id?}', [GroupController::class, 'group_edit'])->name('group_edit');
        Route::post('/group_edit_post/{id?}', [GroupController::class, 'group_update'])->name('group_edit_post');
        Route::get('/group_delete/{id?}', [GroupController::class, 'group_delete'])->name('group_delete');

        // GROUP TO USER
        Route::get('/group_users', [GroupUserController::class, 'group_users'])->name('group_users');
        Route::get('/add_group_user', [GroupUserController::class, 'group_user_add'])->name('group_insert_user');
        Route::post('/add_group_user_post', [GroupUserController::class, 'group_user_post'])->name('post_group_user');
        Route::get('/group_user_edit/{id?}', [GroupUserController::class, 'group_user_edit'])->name('group_user_edit');
        Route::post('/group_user_edit_post/{id?}', [GroupUserController::class, 'group_user_update'])->name('group_user_edit_post');
        Route::get('/group_user_delete/{id?}', [GroupUserController::class, 'group_user_delete'])->name('group_user_delete');

        // JURNAL
        Route::get('/jurnal', [JurnalController::class, 'jurnal'])->name('jurnal');
        Route::get('/add_jurnal', [JurnalController::class, 'jurnal_add'])->name('jurnal_insert');
        Route::post('/add_jurnal_post', [JurnalController::class, 'jurnal_post'])->name('post_jurnal');
        Route::get('/jurnal_edit/{id?}', [JurnalController::class, 'jurnal_edit'])->name('jurnal_edit');
        Route::post('/jurnal_edit_post/{id?}', [JurnalController::class, 'jurnal_update'])->name('jurnal_edit_post');
        Route::get('/jurnal_delete/{id?}', [JurnalController::class, 'jurnal_delete'])->name('jurnal_delete');
        
    });
});
Route::get('/logout', [LoginController::class, 'exit'])->middleware('isAdmin')->name('logout');


