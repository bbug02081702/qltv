<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AutherController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PublisherController;

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
Route::resource('book', BookController::class);
Route::resource('category', CategoryController::class);
Route::resource('publisher', PublisherController::class);
Route::resource('auther', AutherController::class);
Route::resource('student', StudentController::class);