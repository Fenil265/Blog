<?php

use App\Http\Controllers\BlogsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('blogs', [BlogsController::class, 'index']);
Route::get('categories', [CategoriesController::class, 'index']);
Route::get('blog/{id}', [BlogsController::class, 'show']);

Route::post('user/register', [UserController::class, 'store']);
Route::post('user/login', [UserController::class, 'login']);
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('user/blog/add', [BlogsController::class, 'store']);
    Route::get('user/blogs', [UserController::class, 'blogList']);
    Route::put('user/blog/update/{id}', [BlogsController::class, 'edit']);
    Route::delete('user/blog/delete/{id}', [BlogsController::class, 'destroy']);
    Route::get('user', [UserController::class, 'getAuthenticatedUser']);
    Route::post('user/logout', [UserController::class, 'logout']);
});
