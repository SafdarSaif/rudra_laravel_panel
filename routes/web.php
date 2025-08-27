<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\AcadmicsController;

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

// Route::get('/', function () {return view('welcome');});
Route::view('/', 'auth.login')->name('login');
Route::post('loggedin',[HomeController::class,'userLogin'])->name('loggedin');

Route::group(['middleware' => ['usercheck:webadmin']], function(){

    Route::get('dashboard',[UserController::class,'dashboard'])->name('dashboard');

    Route::get('/university', [UniversityController::class, 'index'])->name('university');
    Route::get('/course', [CourseController::class, 'index'])->name('course');
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/student', [StudentController::class, 'index'])->name('student');

    //university
    Route::view('create_university', 'form.university.create')->name('create_university');
    Route::post('add_university', [UniversityController::class, 'create'])->name('add_university');
    Route::get('edit_university/{id}', [UniversityController::class, 'edit'])->name('edit_university');
    Route::post('update_university/{id}', [UniversityController::class, 'update'])->name('update_university');
    Route::get('deleteuniversity/{id}', [UniversityController::class, 'destroy'])->name('deleteuniversity');

    //course
    Route::view('create_course', 'form.course.create')->name('create_course');
    Route::post('add_course', [CourseController::class, 'create'])->name('add_course');
    Route::get('edit_course/{id}', [CourseController::class, 'edit'])->name('edit_course');
    Route::post('update_course/{id}', [CourseController::class, 'update'])->name('update_course');
    Route::get('deletecourse/{id}', [CourseController::class, 'destroy'])->name('deletecourse');


    //user
    Route::view('create_user', 'form.user.create')->name('create_user');
    Route::post('add_user', [UserController::class, 'create'])->name('add_user');
    Route::get('edit_user/{id}', [UserController::class, 'edit'])->name('edit_user');
    Route::post('update_user/{id}', [UserController::class, 'update'])->name('update_user');
    Route::get('deleteuser/{id}', [UserController::class, 'destroy'])->name('deleteuser');
    Route::post('changestatus-user', [UserController::class, 'changeUser'])->name('changestatus-user');
    Route::get('downloadInvoice/{id}', [UserController::class, 'downloadUserPdf'])->name('downloadInvoice');


    //student
    Route::view('create_student', 'form.student.create')->name('create_student');
    Route::post('add_student', [StudentController::class, 'create'])->name('add_student');
    Route::get('edit_student/{id}', [StudentController::class, 'edit'])->name('edit_student');
    Route::post('update_student/{id}', [StudentController::class, 'update'])->name('update_student');
    Route::get('deletestudent/{id}', [StudentController::class, 'destroy'])->name('deletestudent');
    Route::get('downloadfrom/{id}', [StudentController::class, 'downloadForm'])->name('downloadfrom');

    //Acadamics
    Route::get('add_adcadmics/{id}', [AcadmicsController::class, 'addAdcadmics'])->name('add_adcadmics');
    Route::post('store_acadmics', [AcadmicsController::class, 'storeAcadmics'])->name('store_acadmics');
    //Ledgers
    Route::get('studentLedgers', [LedgerController::class, 'getStudenLedgers'])->name('studentLedgers');
    Route::get('cerateledgers', [LedgerController::class, 'getStudentFee'])->name('cerateledgers');
    Route::get('getstudentfee/{id}', [LedgerController::class, 'getStudentFee'])->name('getstudentfee');
    Route::post('update_ledgers', [LedgerController::class, 'addpayment'])->name('update_ledgers');



    Route::get('/get-fee-details/{id}', [LedgerController::class, 'getFeeDetails']);
    Route::post('/update-fee-status/{id}', [LedgerController::class, 'updateFeeStatus']);
    Route::post('/send-welcome-mail/{id}', [StudentController::class, 'sendWelcomeMail']);



        // Route::post('/update-fee-status/{id}', [LedgerController::class, 'sendMailBasedOnLedger']);






});
