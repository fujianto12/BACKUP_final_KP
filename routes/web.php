<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\SelfLearningController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;

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



// Route::get('/', function () {
//     return redirect()->route('register');
// });
Route::get('/', function () {
    return view('home');
});
Route::get('/about', function () {
    return view('guess_menu/about');
});
Route::get('/contact', function () {
    return view('guess_menu/contact');
});
Route::get('/visimisi', function () {
    return view('guess_menu/visimisi');
});
// Route::get('/selflearning', function () {
//     return view('client/selflearning');
// });
// if (Auth::check()) {
//     // Jika sudah login, arahkan ke halaman awal (misalnya dashboard atau home)
//     return redirect()->route('client.home');
// }



Route::group(['middleware' => ['auth', 'no-cache']], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    // Route::get('test', [\App\Http\Controllers\TestController::class, 'index'])->name('client.test');
    // Route::post('test', [\App\Http\Controllers\TestController::class, 'store'])->name('client.test.store');
    Route::get('results/{result_id}', [\App\Http\Controllers\ResultController::class, 'show'])->name('client.results.show');
    Route::get('selflearning', [\App\Http\Controllers\SelfLearningController::class, 'index'])->name('selflearning.index');
    Route::get('modules/{id}', [\App\Http\Controllers\Admin\ModuleController::class, 'show'])->name('modules.show');


    Route::get('test', [TestController::class, 'index'])->name('client.test');
    Route::get('/test/{category}', [TestController::class, 'showByCategory'])->name('client.test.category');
    Route::post('/test/{category}', [TestController::class, 'storeAnswers'])->name('client.test.store');

    // Route::get('/profil', [UserController::class, 'showProfile'])->name('profil');
    Route::get('/profil', [UserController::class, 'showProfile'])->middleware('auth')->name('profil');





    Route::group(['middleware' => ['isAdmin', 'no-cache'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
        Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
        Route::delete('permissions_mass_destroy', [\App\Http\Controllers\Admin\PermissionController::class, 'massDestroy'])->name('permissions.mass_destroy');
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
        Route::delete('roles_mass_destroy', [\App\Http\Controllers\Admin\RoleController::class, 'massDestroy'])->name('roles.mass_destroy');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::delete('users_mass_destroy', [\App\Http\Controllers\Admin\UserController::class, 'massDestroy'])->name('users.mass_destroy');

        // categories
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::delete('categories_mass_destroy', [\App\Http\Controllers\Admin\CategoryController::class, 'massDestroy'])->name('categories.mass_destroy');

        // questions
        Route::resource('questions', \App\Http\Controllers\Admin\QuestionController::class);
        Route::get('/detailsoal/{id}', [\App\Http\Controllers\Admin\QuestionController::class, 'detailSoalById'])->name('detailsoal.index');

        Route::delete('questions_mass_destroy', [\App\Http\Controllers\Admin\QuestionController::class, 'massDestroy'])->name('questions.mass_destroy');

        // options
        Route::resource('options', \App\Http\Controllers\Admin\OptionController::class);
        Route::delete('options_mass_destroy', [\App\Http\Controllers\Admin\OptionController::class, 'massDestroy'])->name('options.mass_destroy');

        // results
        Route::resource('results', \App\Http\Controllers\Admin\ResultController::class);
        Route::delete('results_mass_destroy', [\App\Http\Controllers\Admin\ResultController::class, 'massDestroy'])->name('results.mass_destroy');

        // module
        Route::resource('modules', \App\Http\Controllers\Admin\ModuleController::class);
        Route::delete('modules_mass_destroy', [\App\Http\Controllers\Admin\ModuleController::class, 'massDestroy'])->name('modules.mass_destroy');
        Route::post('modules/store-multiple', [\App\Http\Controllers\Admin\ModuleController::class, 'storeMultiple'])->name('modules.storeMultiple');
    });
});


Route::middleware(['guest', 'no-cache'])->group(function () {
    Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::get('register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
});



Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Halaman dashboard admin
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Resource user (controller UserController)
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});


Auth::routes();
