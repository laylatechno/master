<?php
use App\Http\Controllers\AchievementProductsController;
use App\Http\Controllers\AchievementStimuliController;
use App\Http\Controllers\AchievementsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StimuliController;
use App\Http\Controllers\DevelopmentCategoriesController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\ParentsController;
 

use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriBlogController;
use App\Http\Controllers\LogHistoriController;
use App\Http\Controllers\MenuGroupController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RouteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('achievement_products', AchievementProductsController::class);
    Route::resource('achievement_stimuli', AchievementStimuliController::class);
    Route::resource('achievements', AchievementsController::class);
    Route::resource('products', ProductsController::class);
    Route::resource('stimuli', StimuliController::class);
    Route::resource('development_categories', DevelopmentCategoriesController::class);
    Route::resource('children', ChildrenController::class);
    Route::resource('parents', ParentsController::class);


 

    Route::resource('routes', RouteController::class);
    Route::get('/generate-routes', [RouteController::class, 'generateRoutes'])->name('routes.generate');
    Route::resource('log_histori', LogHistoriController::class);
    Route::get('/log-histori/delete-all', [LogHistoriController::class, 'deleteAll'])->name('log-histori.delete-all');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('profil', ProfilController::class);
    Route::resource('menu_group', MenuGroupController::class);
    Route::resource('menu_item', MenuItemController::class);
    Route::post('menu-item/update-positions', [MenuItemController::class, 'updatePositions'])->name('menu_item.update_positions');
    Route::post('menu-group/update-positions', [MenuGroupController::class, 'updatePositions'])->name('menu_group.update_positions');
    Route::get('/create-resource', [ResourceController::class, 'createForm'])->name('resource.create');
    Route::post('/create-resource', [ResourceController::class, 'createResource'])->name('resource.store');


    Route::resource('blog', BlogController::class);
    Route::resource('kategori_blog', KategoriBlogController::class);

});
