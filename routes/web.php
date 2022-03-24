<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//forum routes
Route::prefix('forum')->group(function () {
    Route::get('/', [App\Http\Controllers\ForumController::class, 'index'])->name('forum.home');
    Route::get('/student', [App\Http\Controllers\ForumController::class, 'studentForum']);
    Route::get('/staff', [App\Http\Controllers\ForumController::class, 'staffForum']);
    Route::post('/student', [App\Http\Controllers\ForumController::class, 'storeStudent']);
});

//people routes
Route::get('/people', [App\Http\Controllers\PeopleController::class, 'index'])->name('people.home');
Route::get('/people/student', [App\Http\Controllers\PeopleController::class, 'getStudent'])->name('people.student');
Route::get('/people/student/{facultycode}/{batch}', [App\Http\Controllers\PeopleController::class, 'getStudentList'])->name('people.studentList');
Route::get('/people/student/{facultyName}/{batch}/{id}', [App\Http\Controllers\PeopleController::class, 'getProfile']);
Route::get('uop/student/profile/{username}', [App\Http\Controllers\PeopleController::class, 'getProfileDetails'])->name('people.profile');
Route::get('/people/academic', [App\Http\Controllers\PeopleController::class, 'getAcademic'])->name('people.academic');

//Route for admin users( only super admin and admins can access these routes )
Route::group(['middleware' => ['admin.users']], function () {

    Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'index'])->name('dashboard');

    //Routes that can be only access by the super admins
    Route::group(['middleware' => ['super.admin']], function() {
        Route::get('/dashboard/delete/{user}', [App\Http\Controllers\UserController::class, 'delete']);
        Route::get('/dashboard/edit/{user}', [App\Http\Controllers\UserController::class, 'edit']);
        Route::put('/dashboard/{user}', [App\Http\Controllers\UserController::class, 'update']);
    });

    //Routes that can be only access by the admin
    Route::group(['middleware' => ['admin']], function() {

    });
});

//Route for non admin users( only students, academic staff and non academic staff can access these routes )
Route::group(['middleware' => ['non.admin.users']], function () {
});

//tempory route
Route::get('/profile', [App\Http\Controllers\PeopleController::class, 'getProfile']);

// Routes for the site activity logging
Route::group(['prefix' => 'activity', 'namespace' => 'App\Http\Controllers', 'middleware' => ['web', 'super.admin', 'activity']], function () {

    // Dashboards
    Route::get('/', 'LaravelLoggerController@showAccessLog')->name('activity');
    Route::get('/cleared', ['uses' => 'LaravelLoggerController@showClearedActivityLog'])->name('cleared');

    // Drill Downs
    Route::get('/log/{id}', 'LaravelLoggerController@showAccessLogEntry');
    Route::get('/cleared/log/{id}', 'LaravelLoggerController@showClearedAccessLogEntry');

    // Forms
    Route::delete('/clear-activity', ['uses' => 'LaravelLoggerController@clearActivityLog'])->name('clear-activity');
    Route::delete('/destroy-activity', ['uses' => 'LaravelLoggerController@destroyActivityLog'])->name('destroy-activity');
    Route::post('/restore-log', ['uses' => 'LaravelLoggerController@restoreClearedActivityLog'])->name('restore-activity');
});