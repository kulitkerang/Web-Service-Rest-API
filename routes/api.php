<?php

use Illuminate\Http\Request;

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

/**
 * Private Access
 */
Route::post('register', 'API\RegisterController@register');
  
Route::middleware('auth:api')->group( function () {
    
        Route::get('/user', function(Request $request){
        return $request->user();
    });
// Route::resource('product', 'API\ProductController');

});

/**
 * Public Access
 */

Route::resource('product', 'API\ProductController');

/**
 * Private Access
 */
// Route::middleware('auth:api')->group( function () {
    // Route::resource('products', 'API\ProductController');
    //     Route::get('/user', function(Request $request){
    //     return $request->user();
//     Route::post('/register', 'Auth\AutentikasiController@register');

// });


// Route::post('/login', 'Auth\AutentikasiController@login');


Route::get('/data', function(){
    $success = "Public Access";
    return response()->json(['message' => $success], 200);


});

