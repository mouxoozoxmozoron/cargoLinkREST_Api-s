<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\web\management_controller;
use App\Http\Controllers\web\user_controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('login', function () {
return view('screens/auth/login');
})->name('login');

Route::get('exit', function () {
    if (session()->has('user_id')) {
        session()->pull('user_id');
        session()->pull('user_object');
        return redirect('/');
    }
})->name("exit");

Route::get('register', function () {
return view('screens/auth/register');
});

Route::POST('login_check', [user_controller::class, 'login'])->name('login_check');
Route::POST('registration_check', [user_controller::class, 'registration'])->name('registration_check');


// Route::post('login_check', function () {
// return "get data from the form";
// });


Route::get('dashboard', [management_controller::class, 'dashboard'])->name('dashboard.home');
Route::get('companyorder/{id}', [management_controller::class, 'companyorder'])->name('dashboard.companyorder');
Route::get('companyorder_delete/{id}', [management_controller::class, 'deleteorder'])->name('dashboard.companyorder.delete');
Route::get('companyorder_deliver/{id}', [management_controller::class, 'deliverorder'])->name('dashboard.companyorder.deliver');
Route::get('company_edit/{id}', [management_controller::class, 'editorder'])->name('dashboard.company.edit');

// home_dashboard.blade
