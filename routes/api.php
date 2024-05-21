<?php

use App\Http\Controllers\api\v1\StudentsController;
use App\Http\Controllers\api\v1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix'=>'v1','namespace'=>'App\Http\Controllers\api\v1','middleware'=>['auth:sanctum']],function(){
    Route::apiResource('students',StudentsController::class);
});

Route::group(['prefix'=>'v1','namespace'=>'App\Http\Controllers\api\v1', 'middleware'=>['auth:sanctum']],function(){
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::put('/posts/{id}', [PostController::class, 'update']); 
    Route::apiResource('posts', PostController::class);
});

// Route::get('/users',[UserController::class,'index']);
// Route::get('/users/{id}',[UserController::class,'show']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/account/profile', [UserController::class, 'update']);

}); 

Route::post('/login',[UserController::class,'login']);
// Route::post('/register',[UserController::class,'register']);

Route::post('/register', [UserController::class, 'register']);

Route::post('/logout',[UserController::class,'logout']);