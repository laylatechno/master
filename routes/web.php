<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriBlogController;
use App\Http\Controllers\MenuGroupController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});
  
Auth::routes();
  
Route::get('/home', [HomeController::class, 'index'])->name('home');
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('profil', ProfilController::class);
    Route::resource('menu_group', MenuGroupController::class);
    Route::resource('menu_item', MenuItemController::class);
    Route::resource('blog', BlogController::class);
    Route::resource('kategori_blog', KategoriBlogController::class);
});
