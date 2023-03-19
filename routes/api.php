<?php

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

Route::apiResource('/posts', App\Http\Controllers\Api\PostController::class);
// Route::apiResource('/inbound', App\Http\Controllers\Api\InboundController::class);
// Route::apiResource('/outbound', App\Http\Controllers\Api\OutboundController::class);

Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum','role:Operator']], function() {    
    Route::delete('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);    
    Route::post('/refresh', [App\Http\Controllers\Api\AuthController::class, 'refresh']); 
    Route::post('/change-password', [App\Http\Controllers\Api\AuthController::class, 'changePassword']);   
    Route::get('/get-user', [App\Http\Controllers\Api\AuthController::class, 'getUser']);   
    Route::post('/change-photo', [App\Http\Controllers\Api\AuthController::class, 'changePhoto']);  
    Route::get('/get-photo', [App\Http\Controllers\Api\AuthController::class, 'getPhoto']);  


    Route::controller(App\Http\Controllers\Api\DashboardController::class)->group(function () {        
        Route::get('dokumen/count', 'countInventory');
        Route::get('dokumen/transaksi-belum', 'transaksiBelum');
        Route::get('dokumen/material', 'materialList');        
        Route::get('dokumen/transaksi-hari', 'transaksiHari');
        Route::get('dokumen/scan', 'scanDokumen');
        Route::get('notifikasi', 'notificationList');
        Route::get('dashboard', 'home');
        
        Route::get('my-transaction/list', 'listMyTransaction');
    });
    Route::controller(App\Http\Controllers\Api\DocumentController::class)->group(function () {
        Route::get('dokumen', 'index');    
    });

    Route::controller(App\Http\Controllers\Api\StorageController::class)->group(function () {
        Route::get('storage', 'locationMenu');    
    });

    Route::controller(App\Http\Controllers\Api\MaterialController::class)->group(function () {
        Route::get('materials', 'index');    
        Route::get('materials/detail', 'detailMaterial');    
        Route::get('materials/storage', 'storageMaterial');    
        Route::get('materials/history', 'historyMaterial');    
    });


    Route::controller(App\Http\Controllers\Api\TransactionController::class)->group(function () {
        Route::get('info-sttp', 'infoDetailInbound');    
        Route::get('info-bpm', 'infoDetailOutbound');    
        Route::get('request-location', 'locationRequest');
        Route::get('request-bin', 'binRequest');

        Route::get('request-type', 'locationTypeRequest');
        Route::get('request-type-bin', 'locationTypeBinRequest');        

        Route::POST('sttp-post', 'requestPostInbound');        
        Route::POST('sttp-done', 'sttpDone');     

        Route::POST('bpm-post', 'requestPostOutbound');        
        Route::POST('bpm-done', 'bpmDone');     

        Route::POST('bpm-destination', 'bpmDestination');     
    });
    
    
});
Route::post('email/verification-notification', [App\Http\Controllers\Api\EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');   
Route::get('verify-email/{id}/{hash}', [App\Http\Controllers\Api\EmailVerificationController::class, 'verify'])->name('verification.verify');

Route::get('/verified-only', function(Request $request){

    dd('your are verified', $request->user()->name);
})->middleware('auth:Api','verified');


Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'createUser']);
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'loginUser']);

Route::post('/forgot-password-api', [App\Http\Controllers\Api\NewPasswordController::class, 'forgotPassword']);
Route::post('/reset-password-api', [App\Http\Controllers\Api\NewPasswordController::class, 'reset']);

Route::post('/fcm-token', [App\Http\Controllers\Api\NotifikasiController::class, 'updateToken'])->name('fcmToken');
Route::post('/send-notification',[App\Http\Controllers\Api\NotifikasiController::class,'notification'])->name('notification');