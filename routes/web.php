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

Route::get('/search', [App\Http\Controllers\SearchController::class, 'searchStudents']);

Route::get('/creaters', function () {
    return view('people.team');
});

// Form routes
Route::prefix('form')->group(function () {
    Route::get('/', [App\Http\Controllers\FormController::class, 'index'])->name('form.home');

    Route::get('/student', [App\Http\Controllers\FormController::class, 'studentForm']);
    Route::get('/academic', [App\Http\Controllers\FormController::class, 'academicForm']);
    Route::get('/nonacademic', [App\Http\Controllers\FormController::class, 'nonAcademicForm']);
    
    Route::post('/student', [App\Http\Controllers\FormController::class, 'storeStudent']);

    Route::get('/resubmit/{username}', [App\Http\Controllers\FormController::class, 'resubmission'])->name('form.resubmit');
    Route::post('/resubmit/{username}', [App\Http\Controllers\FormController::class, 'submitResubmission']);

    Route::get('/email/{username}', [App\Http\Controllers\FormController::class, 'verification'])->name('form.verification')->middleware('link');
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
        Route::get('/student/firstlogin/{username}', [App\Http\Controllers\FormController::class, 'get_firstlogin_StudentForm']);
        Route::post('/student/firstlogin/{username}', [App\Http\Controllers\FormController::class, 'store_firstlogin_StudentForm']);
    });
});


//Route for admin users( only super admin and admins can access these routes )
Route::group(['middleware' => ['admin.users']], function () {

    // route: change account visibility
    Route::put('/changeVisibility', [App\Http\Controllers\PeopleController::class, 'changeVisibility']);

    // route: get guidelines
    Route::get('/guidelines', function () {
    return view('guidelines.adminGuidelines');
    });

    // route: dashboard/
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('dashboard');

        // route: go to the excel file upload form and uploading excel file routes
        Route::get('add/excelfile', [App\Http\Controllers\ExcelFileController::class, 'addExcelFile']);
        Route::post('add/excelfile', [App\Http\Controllers\ExcelFileController::class, 'uploadExcelFile']);

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
                Route::get('/department', [App\Http\Controllers\DepartmentController::class, 'createDepartment']);

                Route::post('/user', [App\Http\Controllers\UserController::class, 'addUser']);
                Route::post('/faculty', [App\Http\Controllers\FacultyController::class, 'addFaculty']);
                Route::post('/batch', [App\Http\Controllers\BatchController::class, 'addBatch']);
                Route::post('/department', [App\Http\Controllers\DepartmentController::class, 'addDepartment']);
            });
        });

        /**
         * Routes that can be only access by the admin
         */
        Route::group(['middleware' => ['faculty.admin']], function() {
            // route: dashboard/student
            Route::prefix('student')->group(function () {
                // WARNING:: This /verify/{userId} route must be placed before /{facultyCode}/{batchId} route
                Route::get('/verify/{userId}', [App\Http\Controllers\StudentController::class, 'verifyStudent']);
                Route::post('/reject/{userId}', [App\Http\Controllers\StudentController::class, 'rejectStudent']);
                Route::get('/{userId}', [App\Http\Controllers\StudentController::class, 'getStudent']);
                Route::get('/{facultyCode}/{batchId}', [App\Http\Controllers\StudentController::class, 'getStudentList'])->name('getStudentList'); 
            });
        });
    });
});

//Route for non admin users( only students, academic staff and non academic staff can access these routes )
Route::group(['middleware' => ['non.admin.users','throttle:api']], function () {
    //Routes that can be only access by students
    Route::group(['middleware' => ['student']], function() {
        // Here goes students' profle edit routes
        Route::put('/bio/{username}', [App\Http\Controllers\StudentController::class, 'editBio']);
        Route::put('/socialmedia/{username}', [App\Http\Controllers\StudentController::class, 'editSocialMedia']);
        Route::put('/contacts/{username}', [App\Http\Controllers\StudentController::class, 'editContactDetails']);
    });
});

//tempory route
Route::get('/profile/{id}', [App\Http\Controllers\PeopleController::class, 'getProfile']);

//coming soon route
Route::get('/comingsoon', [App\Http\Controllers\PeopleController::class, 'comingsoon']);

//set password email route
Route::get('/password/register/{username}', [\App\Http\Controllers\StudentController::class, 'setPassword'])->name('password.create');
Route::put('/setpassword/{username}', [\App\Http\Controllers\StudentController::class, 'updatePassword']);

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