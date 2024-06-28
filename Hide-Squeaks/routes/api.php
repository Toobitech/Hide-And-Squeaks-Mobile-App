<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VideoController;

use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\RecordingController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//register/login/logout route
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);

//otp/reset-password route
Route::post('request-otp', [UserController::class, 'requestOtp']);
Route::post('verify-otp', [UserController::class, 'verifyOtp']);
Route::post('reset-password', [UserController::class, 'resetPassword']);

//Route::post('logout', [UserController::class, 'logout']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

  //Ensurance page Route
    // Route::get('/video', [VideoController::class, 'index']);
    // Route::post('/videos', [VideoController::class, 'upload']);
    // Route::get('/record',[RecordingController::class, 'index']);
    // Route::post('records',[RecordingController::class, 'upload']);

Route::middleware('auth:api')->group(function () {

    // Video Routes
    Route::get('/videos', [VideoController::class, 'index']);
    Route::post('/videos-upload', [VideoController::class, 'store']);
    Route::post('/video-del', [VideoController::class, 'destory']);
    Route::post('/multiple-upload', [VideoController::class, 'storeMultiple']);

    Route::controller(HomeController::class)->group(function () {
      //Profile Route
        Route::get('/profile', 'getProfile');
        Route::post('/profile-upload', 'profilePost');

        //Comments Routes
        Route::get('/comment', 'getComment');
        Route::post('/upload-comment', 'commentPost');

        //Like Routes
        Route::get('/like', 'totalNumberOfLikes');
        Route::post('/upload-like', 'likePost');

        Route::get('/audio', 'getAudio');
        Route::get('/my-library', 'myLibrary');
        Route::POST('/add-my-library', 'addMyLibrary');
        Route::POST('/add-paid-sound-my-library', 'addPaidSoundMyLibrary');

        Route::POST('/del-from-library', 'delFromLibrary');
        Route::POST('play-paid-sound','playPaidSound');

        Route::get('/paragraph', 'getLegal');
        Route::post('/view-video', 'videoById'); 
        Route::post('/add-view', 'addView');
        Route::get('/list-treats', 'treatsList');
        Route::get('/my-balance', 'myBalance');

        Route::post('/purchase-treats', 'purchaseTreats');

    });
    Route::controller(RecordingController::class)->group(function () {
        //Profile Route
          Route::get('/recorder', 'index');
          Route::post('recorder/add', 'store');
          Route::post('recorder/delete', 'destroy');


      });



});
