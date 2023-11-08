<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/index/{token}/{id?}', function ($token, $id='') {
    return view('index', ['token' => $token, 'id' => $id]);
});

Route::get('/goToIndex/{userId}', 'FrontController@goToIndex');

Route::get('/productList', function () {
    return view('productList');
});

Route::get('/product/{id}', function ($id) {
    return view('product', ['id' => $id]);
});

Route::get('/liffIsLogin', 'FrontController@liffIsLogin');
// Route::get('/liffIsLogin/{token}', function($token){
//     return $token;
// });

Route::prefix('front')->group(function () {
    $path_info = explode('front/', request()->getPathInfo())[1] ?? '';
    Route::any('/'.$path_info, 'FrontController@'.$path_info);
});

Route::get('/test', 'managreController@Test');





//後台
Route::get('admin/logout', 'managreController@logout');
Route::get('admin/login', function() {
    return view('managre.login');
});
Route::post('checkLogin', 'managreController@login');

Route::middleware('adminauth')->group(function () {
    Route::prefix('axios')->group(function () {
        $path_info = explode('axios/', request()->getPathInfo())[1] ?? '';
        Route::post('/'.$path_info, 'managreController@'.$path_info);
    });
    Route::prefix('managre')->group(function () {
        Route::get('/{path_info}/{params?}', function ($path_info, $params = null) {
            return view('managre.' . $path_info, compact('params'));
        });
    });
});


//站方
Route::get('vendorLogin', function() {
    return view('vendor.login');
});
Route::post('vendorCheckLogin', 'vendorManagementController@login');
Route::get('vendorLogout', 'vendorManagementController@logout');

Route::middleware('vendor')->group(function () {
    Route::prefix('vendor')->group(function () {
        Route::get('/{path_info}/{params?}', function ($path_info, $params = null) {
            return view('vendor.' . $path_info, compact('params'));
        });
    });
    Route::prefix('vendorAxios')->group(function () {
        $path_info = explode('vendorAxios/', request()->getPathInfo())[1] ?? '';
        Route::post('/'.$path_info, 'vendorManagementController@'.$path_info);
    });
});