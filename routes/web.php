<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\materialController;

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

Route::post('/qr', 'App\Http\Controllers\mainController@qr');

Route::get('/testview', 'App\Http\Controllers\mainController@testview');
Route::post('/fetchData', 'App\Http\Controllers\mainController@fetchData');

Route::get('/test', 'App\Http\Controllers\mainController@test');

Route::middleware('auth')->group(function(){

Route::get('/', 'App\Http\Controllers\mainController@index');

Route::get('/getFile/{namafile}', 'App\Http\Controllers\profileController@getFile');


Route::get('/transaksi', 'App\Http\Controllers\transaksiController@index');
	Route::get('/detailsttp/{id}', 'App\Http\Controllers\transaksiController@sttpdetail');
	Route::get('/detailbpm/{id}', 'App\Http\Controllers\transaksiController@bpmdetail');
	Route::get('/detailgi/{id}', 'App\Http\Controllers\transaksiController@gidetail');


Route::get('/materialmove', [App\Http\Controllers\materialController::class, 'move']);
Route::get('/materialmoved/{id}', [App\Http\Controllers\materialController::class, 'moved']);
	Route::post('/materialmovedprocess', [App\Http\Controllers\materialController::class, 'movedprocess']);


Route::get('/materialstock', [App\Http\Controllers\materialController::class, 'index']);
	Route::get('/materialstockdetail/{id}', [App\Http\Controllers\materialController::class, 'detail']);
	Route::get('/getFileTransaction/{namafile}', [App\Http\Controllers\materialController::class, 'getFileTransaction']);
	Route::get('/transaction-image', [App\Http\Controllers\materialController::class, 'preview']);

Route::get('/material', [App\Http\Controllers\materialController::class, 'material']);
	Route::get('/material/fetch_data', [materialController::class, 'fetch_data']);
Route::get('/materialgroup', [App\Http\Controllers\materialController::class, 'group']);
Route::get('/materialtype', [App\Http\Controllers\materialController::class, 'type']);


Route::get('/report', 'App\Http\Controllers\reportController@index');
Route::get('/report1', 'App\Http\Controllers\reportController@report1');
Route::get('/report2', 'App\Http\Controllers\reportController@report2');
Route::get('/report2data', 'App\Http\Controllers\reportController@report2data')->name('data.report2');
Route::get('/generate', 'App\Http\Controllers\reportController@generate');
Route::get('/generated-report', 'App\Http\Controllers\reportController@generateReport');


Route::get('/uom', 'App\Http\Controllers\masterController@uom');
Route::get('/wbs', 'App\Http\Controllers\masterController@wbs');


Route::get('/pivot', 'App\Http\Controllers\layoutpenyimpananController@pivot');
	Route::get('/data_bin', 'App\Http\Controllers\layoutpenyimpananController@getBin')->name('data.bin');
	Route::post('/addpivot', 'App\Http\Controllers\layoutpenyimpananController@addpivot');
Route::get('/qr_code', 'App\Http\Controllers\FileController@getQrCode');
Route::get('/plant', 'App\Http\Controllers\layoutpenyimpananController@plant');
Route::get('/storloc', 'App\Http\Controllers\layoutpenyimpananController@storloc');
Route::get('/type', 'App\Http\Controllers\layoutpenyimpananController@type');


Route::get('/notification', 'App\Http\Controllers\notification@index');


Route::get('/usermanagement', 'App\Http\Controllers\profileController@user');
	Route::post('/addusermanagement', 'App\Http\Controllers\profileController@add');
	Route::get('/edituser/{id}', 'App\Http\Controllers\profileController@profile');
	Route::post('/prosesediteuser/', 'App\Http\Controllers\profileController@edit');
	Route::get('/deleteuser/{id}', 'App\Http\Controllers\profileController@deleteuser');
Route::get('/profile/{id}', 'App\Http\Controllers\profileController@profile');
	Route::post('/editprofile', 'App\Http\Controllers\profileController@editprofile');
	Route::post('/editpassword', 'App\Http\Controllers\profileController@editpassword');


});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/resetpass', [App\Http\Controllers\mainController::class, 'forgot']);

Route::get('/file', [App\Http\Controllers\FileController::class, 'store']);
Route::get('/get-file', [App\Http\Controllers\FileController::class, 'getFile']);
Route::get('/dd', function (Request $request) {
    $dad =\App\Models\sap_m_wbs::all()->pluck('id', 'wbs_desc');
    
});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
