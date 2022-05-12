<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\EventInviteController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[UserAuthController::class,"register"] )->middleware("guest")->name("register");
Route::post('/login',[UserAuthController::class,"login"] )->middleware("guest")->name("login");
Route::post('/logout',[UserAuthController::class,"logout"] )->middleware("auth:api")->name("logout");
Route::post('/updatePassword',[UserAuthController::class,"updatePassword"] )->middleware("auth:api");
Route::post('/resetPassword',[UserAuthController::class,"resetPassword"] )->middleware("guest");
Route::post("/updateResetPassword",[UserAuthController::class,"changePassword"])->name("password.update.api");
Route::apiResource("/events",EventsController::class)->middleware("auth:api");
Route::apiResource("/eventInvites",EventInviteController::class)->middleware("auth:api");
Route::get("/AllEvents",[EventsController::class,"AllEventsOfAUser"])->middleware("auth:api");




