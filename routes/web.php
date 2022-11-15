<?php
use Spatie\WelcomeNotification\WelcomesNewUsers;
use App\Http\Controllers\Auth\MyWelcomeController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ResetpasswordController;
use App\Http\Controllers\SetpasswordController;
use App\Http\Controllers\UserController;
use App\Notifications\SetPasswordNotification;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
Route::get('/',function(){
    return view('login');
})->name('login');
Route::get('logout',[LogoutController::class,'logout'])->name('logout');

Route::post('/login/check',[LoginController::class ,'login'])->name('login.check');

Route::middleware(['auth'])->group(function(){

Route::get('users',[UserController::class ,'index'])->name('users.index');

Route::get('users/create',[UserController::class ,'create'])->name('users.create');
Route::post('users/store',[UserController::class,'store'])->name('users.store');

Route::get('users/{user:slug}/edit',[UserController::class,'edit'])->name('users.edit');
Route::post('users/{user}/update',[UserController::class,'update'])->name('users.update');

Route::delete('users/{user}/delete',[UserController::class,'delete'])->name('users.delete');

Route::get('users/{user}/status',[UserController::class,'status'])->name('users.status');

Route::get('set-password/{user:slug}', [SetpasswordController::class, 'index'])
    ->name('setpassword');

Route::post('set-password/{user}', [SetpasswordController::class, 'setpassword'])
    ->name('set-password');
 


Route::get('reset-password/{user:slug}', [ResetpasswordController::class, 'index']);

Route::post('reset-password/{user}',[ResetpasswordController::class,'resetpassword'])->name('reset-password');


Route::get('categories',[CategoryController::class,'index'])->name('categories.index');

Route::get('categories/create',[CategoryController::class,'create'])->name('categories.create');
Route::post('categories/store',[CategoryController::class,'store'])->name('categories.store');

Route::get('categories/{category:slug}/edit',[CategoryController::class,'edit'])->name('categories.edit');
Route::post('categories/{category}/update',[CategoryController::class,'update'])->name('categories.update');

Route::delete('categories/{category}/delete',[CategoryController::class,'delete'])->name('categories.delete');

Route::get('categories/{category}/status',[CategoryController::class,'status'])->name('categories.status');

Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

Route::get('/employee',[DashboardController::class,'employee'])->name('employee');

});

// welcome WelcomeNotification

Route::group(['middleware' => ['web', WelcomesNewUsers::class,]], function () {
    Route::get('welcome/{user}', [MyWelcomeController::class, 'showWelcomeForm'])->name('welcome');
    Route::post('welcome/{user}', [MyWelcomeController::class, 'savePassword']);
});
