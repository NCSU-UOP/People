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
})->middleware('throttle:api');

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('throttle:api');

Route::get('/creaters', function () {
    return view('people.team');
});

// Forum routes
Route::prefix('forum')->group(function () {
    Route::get('/', [App\Http\Controllers\ForumController::class, 'index'])->name('forum.home');

    Route::get('/student', [App\Http\Controllers\ForumController::class, 'studentForum']);
    Route::get('/staff', [App\Http\Controllers\ForumController::class, 'staffForum']);
    
    Route::post('/student', [App\Http\Controllers\ForumController::class, 'storeStudent']);

    Route::get('/{username}/register', [App\Http\Controllers\ForumController::class, 'verification'])->name('forum.verification');
    Route::put('/{username}/setpassword', [App\Http\Controllers\ForumController::class, 'updatePassword']);

    Route::get('/resubmit/{username}', [App\Http\Controllers\ForumController::class, 'resubmission'])->name('forum.resubmit');
});
 
// These are public routes which provides users' profile to the outsiders
Route::prefix('people')->group(function () {
// Can select one of the three user profile categories
    Route::get('/', [App\Http\Controllers\PeopleController::class, 'index'])->name('people.home');

    // Students routes
    Route::prefix('student')->group(function () {
        // Can select the faculty and the batch of the student users
        Route::get('/', [App\Http\Controllers\PeopleController::class, 'getStudent'])->name('people.student');
        
        // Thie route is used to redirect outsider to the respective students's profile
        Route::get('/{id}', [App\Http\Controllers\PeopleController::class, 'getProfile']);

        // Shows all the verified student available in the respective batch of the selected faculty
        Route::get('/{facultycode}/{batch}', [App\Http\Controllers\PeopleController::class, 'getStudentList'])->name('people.studentList');
    });

// Academic staff  routes. Still in the development process
    Route::get('/academic', [App\Http\Controllers\PeopleController::class, 'getAcademic'])->name('people.academic');

// Non-Academic staff  routes. Still in the development process
    Route::get('/nonacademic', [App\Http\Controllers\PeopleController::class, 'getNonAcademic'])->name('people.nonAcademic');
});


// User profiles routes
Route::prefix('uop')->group(function () {
    // student category
    Route::group(['middleware' => ['unverified']], function () {
        Route::get('/student/profile/{username}', [App\Http\Controllers\PeopleController::class, 'getProfileDetails'])->name('people.profile');
    });
});


//Route for admin users( only super admin and admins can access these routes )
Route::group(['middleware' => ['admin.users']], function () {

    // route: dashboard/
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('dashboard'); 

        /**
         * Routes that can be only access by the super admins
         */
        Route::group(['middleware' => ['super.admin']], function() {
            Route::get('/delete/{user}', [App\Http\Controllers\UserController::class, 'delete']);
            Route::get('/edit/{user}', [App\Http\Controllers\UserController::class, 'edit']);
            Route::put('/{user}', [App\Http\Controllers\UserController::class, 'update']);

            // route: dashboard/add
            Route::prefix('add')->group(function () {
                Route::get('/user', [App\Http\Controllers\UserController::class, 'createUser']);
                Route::get('/faculty', [App\Http\Controllers\FacultyController::class, 'createFaculty']);
                Route::get('/batch', [App\Http\Controllers\BatchController::class, 'createBatch']);

                Route::post('/user', [App\Http\Controllers\UserController::class, 'addUser']);
                Route::post('/faculty', [App\Http\Controllers\FacultyController::class, 'addFaculty']);
                Route::post('/batch', [App\Http\Controllers\BatchController::class, 'addBatch']);
            });
        });

        /**
         * Routes that can be only access by the admin
         */
        Route::group(['middleware' => ['admin']], function() {
            // route: dashboard/student
            Route::prefix('student')->group(function () {
                // WARNING:: This /verify/{userId} route must be placed before /{facultyCode}/{batchId} route
                Route::get('/verify/{userId}', [App\Http\Controllers\UserController::class, 'verifyStudent']);
                Route::post('/reject/{userId}', [App\Http\Controllers\UserController::class, 'rejectStudent']);
                Route::get('/{userId}', [App\Http\Controllers\UserController::class, 'getStudent']);
                Route::get('/{facultyCode}/{batchId}', [App\Http\Controllers\UserController::class, 'getStudentList'])->name('getStudentList'); 
            });
        });
    });
});

//Route for non admin users( only students, academic staff and non academic staff can access these routes )
Route::group(['middleware' => ['non.admin.users','throttle:api']], function () {
    //Routes that can be only access by students
    Route::group(['middleware' => ['student']], function() {
        // Here goes students' profle edit routes

    });
});

//tempory route
Route::get('/profile/{id}', [App\Http\Controllers\PeopleController::class, 'getProfile']);

//coming soon route
Route::get('/comingsoon', [App\Http\Controllers\PeopleController::class, 'comingsoon']);

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