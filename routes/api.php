<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\GovernmentController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\api\HomeController;
use App\Http\Controllers\ReversationController;
use App\Http\Controllers\api\ServiceController;

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

Route::post('/createGovernment',[GovernmentController::class, 'create'])->name('government.create');
Route::post('/createRegion',[RegionController::class, 'create'])->name('region.create');

Route::get('/',[GovernmentController::class, 'index'])->name('index');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('contact/create', [ContactUsController::class, 'store']);
    Route::get('show', [HomeController::class, 'index']);
    Route::get('service', [ServiceController::class, 'show']);

    Route::group(['prefix' => 'government', 'as' => 'government.'], function () {
        Route::get('/',[GovernmentController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'region', 'as' => 'region.'], function () {
        Route::get('/{id}',[RegionController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'filter', 'as' => 'filter.'], function () {
       Route::get('/{cat_id}/{govrn_id}',[ServiceController::class, 'filter'])->name('filter');
        Route::get('/{cat_id}/{govrn_id}/{region_id}',[ServiceController::class, 'filtergovernmentRegion'])->name('filtergovernmentRegion');
    });



    Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
        Route::get('/',[ServiceController::class, 'allCategory'])->name('allCategory');
    });

    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::get('/{id}',[ServiceController::class, 'allProductForCat'])->name('allProductForCat');
Route::get('/prod/{id}',[ServiceController::class, 'getOneProduct'])->name('getOneProduct');
        Route::post('search',[ServiceController::class, 'search'])->name('search');
    });

Route::group(['prefix' => 'reserve', 'as' => 'reserve.'], function () {
        Route::post('/table',[ReversationController::class, 'reversetable'])->name('reversetable');
        Route::post('/room',[ReversationController::class, 'reverseroom'])->name('reverseroom');
        Route::post('/operation',[ReversationController::class, 'reverseoperation'])->name('reverseoperation');
    });
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('/login2', [AuthController::class, 'login'])->name('login');

