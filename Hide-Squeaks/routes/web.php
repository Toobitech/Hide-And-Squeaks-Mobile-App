<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Apps\ProductController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\EnsuranceController;
use App\Http\Controllers\Apps\TreatsDealController;

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
Route::get('upload',[AudioController::class,'formVideo']);
Route::POST('upload-video',[AudioController::class,'postVedio'])->name('post.vedio');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);


    //audio management route
    Route::get('audios', [AudioController::class, 'index'])->name('audios.index');
    Route::get('audios/create', [AudioController::class, 'create'])->name('audios.create');
    Route::post('audios', [AudioController::class, 'store'])->name('audios.store');
    Route::delete('audios/{id}', [AudioController::class, 'destroy'])->name('audios.destroy');
    Route::get('audios/{audio}/edit', [AudioController::class, 'edit'])->name('audios.edit');
    Route::put('audios/{audio}', [AudioController::class, 'update'])->name('audios.update');


//video management route
    Route::get('videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('videos/create', [VideoController::class, 'create'])->name('videos.create');
Route::post('videos', [VideoController::class, 'store'])->name('videos.store');
Route::delete('videos/{id}', [VideoController::class, 'destroy'])->name('videos.destroy');
Route::get('videos/{video}/edit', [VideoController::class, 'edit'])->name('videos.edit');
Route::put('videos/{video}', [VideoController::class, 'update'])->name('videos.update');

// //chunk video file upload routes
// Route::get('upload', [UploadController::class, 'index'])->name('upload.index');
// Route::post('upload', [UploadController::class, 'store'])->name('upload.store');


//product management route
Route::resource('/product-management/products', ProductManagementController::class);
Route::resource('ensurance', EnsuranceController::class);
Route::resource('treats-deal', TreatsDealController::class);
Route::get('/my-profile', [UserManagementController::class,'myProfile'])->name('myprofile');
Route::get('/my-profile-update-email', [UserManagementController::class,'myProfileUpdateEmail'])->name('myprofileUpdateEmail');
Route::get('/my-profile-update-name', [UserManagementController::class,'myProfileUpdateName'])->name('myprofileUpdateName');
Route::get('/my-profile-update-password', [UserManagementController::class,'myProfileUpdatePassword'])->name('myprofileUpdatePassword');



    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });



        // Route::resource('vendor/product', ProductController::class);



});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
