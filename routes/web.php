<?php
use Spatie\WelcomeNotification\WelcomesNewUsers;
use App\Http\Controllers\Auth\MyWelcomeController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseEnrollmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\EnrollController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResetpasswordController;
use App\Http\Controllers\SetpasswordController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserEnrolmentController;
use App\Notifications\SetPasswordNotification;
use Illuminate\Support\Facades\Auth;
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
    if(Auth::check()) {
        if(Auth::user()->isemployee)
        {
            return redirect()->route('learner.index');
        }
        elseif(Auth::user()->IsTrainer) // demo template code...
        {
            return redirect()->route('trainer.index');
        }
        else
        {
            return redirect()->route('dashboard.index');
        }
    }
    else{
        return view('login');
    }

})->name('login');

Route::get('logout',[LogoutController::class,'logout'])->name('logout');

Route::post('/login/check',[LoginController::class ,'login'])->name('login.check');

Route::get('/forgetpassword',[ForgetPasswordController::class ,'index'])->name('forgetpassword');
Route::post('/forgetpassword',[ForgetPasswordController::class ,'forgetpassword'])->name('mail-sending');
Route::get('/settingpassword/{user}',[ForgetPasswordController::class ,'create'])->name('settingpassword');
Route::post('/settingpassword/{user}',[ForgetPasswordController::class ,'store'])->name('password.store');



Route::middleware(['auth'])->group(function(){

Route::controller(UserController::class)->group(function () {

    Route::get('users','index')->name('users.index');

    Route::get('users/create','create')->name('users.create');
    Route::post('users/store','store')->name('users.store');

    Route::get('users/{user:slug}/edit','edit')->name('users.edit');
    Route::post('users/{user}/update','update')->name('users.update');

    Route::delete('users/{user:slug}/delete','delete')->name('users.delete');

    Route::get('users/{user}/status','status')->name('users.status');
});

Route::get('set-password/{user:slug}', [SetpasswordController::class, 'index'])
    ->name('setpassword');

Route::post('set-password/{user}', [SetpasswordController::class, 'setpassword'])
    ->name('set-password');
 


Route::get('reset-password/{user:slug}', [ResetpasswordController::class, 'index'])->name('resetpassword.index');

Route::post('reset-password/{user}',[ResetpasswordController::class,'resetpassword'])->name('reset-password');

Route::controller(CategoryController::class)->group(function () {

    Route::get('categories','index')->name('categories.index');

    Route::get('categories/create','create')->name('categories.create');
    Route::post('categories/store','store')->name('categories.store');

    Route::get('categories/{category:slug}/edit','edit')->name('categories.edit');
    Route::post('categories/{category}/update','update')->name('categories.update');

    Route::delete('categories/{category}/delete','delete')->name('categories.delete');

    Route::get('categories/{category}/status','status')->name('categories.status');

});

Route::controller(CourseController::class)->group(function () {

    Route::get('/courses','index')->name('courses.index');

    Route::get('/courses/create','create')->name('courses.create');
    Route::post('/courses/store','store')->name('courses.store');

    Route::get('/courses/{course:slug}','show')->name('courses.show');

    Route::get('/courses/edit/{course:slug}','edit')->name('courses.edit');
    Route::post('/courses/edit/{course}','update')->name('courses.update');

    Route::get('/courses/status/{course:slug}','status')->name('courses.status');
});

Route::controller(UnitController::class)->group(function () {

    Route::get('/courses/{course:slug}/units/create','create')->name('courses.units.create');
    Route::post('/courses/{course}/units/store/','store')->name('courses.units.store');

    Route::get('/courses/{course:slug}/units/{unit:slug}/edit','edit')->name('courses.units.edit');
    Route::post('/courses/{course}/units/{unit}/update','update')->name('courses.units.update');

    Route::delete('/courses/units/{unit:slug}/delete','delete')->name('courses.units.delete');

});

Route::controller(TestController::class)->group(function () {

    Route::get('/courses/{course:slug}/units/{unit:slug}/tests/create', 'create')->name('courses.units.tests.create');
    Route::post('/courses/{course:slug}/units/{unit:slug}/test/store', 'store')->name('courses.units.tests.store');

    Route::get('/courses/{course:slug}/units/{unit:slug}/tests/{test}/edit', 'edit')->name('courses.units.tests.edit');
    Route::post('/courses/{course:slug}/units/{unit:slug}/tests/{test}/update', 'update')->name('courses.units.tests.update');

    Route::delete('/courses/units/tests/{test}/delete', 'delete')->name('courses.units.tests.delete');

});

Route::get('/courses/{course}/units/{unit}/tests/{test}/questions/create',[QuestionController::class,'create'])->name('courses.units.tests.questions.create');
Route::post('/courses/{course}/units/{unit}/tests/{test}/questions/store',[QuestionController::class,'store'])->name('courses.units.tests.questions.store');

Route::get('/courses/{course}/units/{unit}/tests/{test}/questions/{question}/edit',[QuestionController::class,'edit'])->name('courses.units.tests.questions.edit');
Route::post('/courses/{course}/units/{unit}/tests/{test}/questions/{question}/update',[QuestionController::class,'update'])->name('courses.units.tests.questions.update');

Route::delete('/courses/units/tests/questions/{question}/delete',[QuestionController::class,'delete'])->name('courses.units.tests.questions.delete');



Route::get('courses/{course:slug}/enrolled', [UserEnrolmentController::class,'index'])->name('userenrolled.index');
Route::post('courses/{course}/enrolled', [UserEnrolmentController::class,'store'])->name('userenrolled.store');
Route::delete('courses/{course}/users/{user}/delete', [UserEnrolmentController::class,'delete'])->name('userenrolled.delete');


Route::get('users/{user:slug}/enrolled', [CourseEnrollmentController::class,'index'])->name('enrolledCourse.index');
Route::post('users/{user}/enrolled', [CourseEnrollmentController::class,'store'])->name('enrolledCourse.store');
Route::delete('courses/{course}/users/{user}/destroy', [CourseEnrollmentController::class,'delete'])->name('enrolledCourse.delete');


Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard.index');
Route::get('overview',[DashboardController::class,'overview'])->name('overview.index');


Route::get('/learner/courses',[EmploymentController::class,'index'])->name('learner.index');
Route::get('/learner/courses/{course}/units',[EmploymentController::class,'showUnit'])->name('learner.units');
Route::get('/learner/courses/units/{unit}/tests',[EmploymentController::class,'showTest'])->name('learner.tests');
Route::get('/learner/courses/units/tests/{test}/questions',[EmploymentController::class,'showQuestion'])->name('learner.questions');
Route::post('/learner/courses/units/tests/{test}/questions/{question}/store',[EmploymentController::class,'store'])->name('learner.questions.store');

//demo template code

Route::get('/admin/templates', [TemplateController::class,'adminIndex'])->name('admin_template.index');
Route::get('admin/templates/edit/{template}', [TemplateController::class,'edit'])->name('template.edit');
Route::post('admin/templates/update/{template}', [TemplateController::class,'update'])->name('template.update');
Route::post('admin/templates/delete/{template}', [TemplateController::class,'delete'])->name('template.delete');
Route::post('admin/templates/delete/{template}', [TemplateController::class,'delete'])->name('template.delete');
Route::get('admin/templates/push/{template}', [TemplateController::class,'push'])->name('templates.push');

Route::get('/trainer',[TemplateController::class,'index'])->name('trainer.index');
Route::get('/templates/{user}',[TemplateController::class,'create'])->name('trainer.create');


});


// welcome WelcomeNotification

Route::group(['middleware' => ['web', WelcomesNewUsers::class,]], function () {
    Route::get('welcome/{user}', [MyWelcomeController::class, 'showWelcomeForm'])->name('welcome');
    Route::post('welcome/{user}', [MyWelcomeController::class, 'savePassword']);
});
