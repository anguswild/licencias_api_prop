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

Route::post('login', 'UserController@login');

Route::group(['middleware' => ['cors']], function()
{
   Route::post('register', 'UserController@register');
   Route::post('details', 'UserController@details');
   
   Route::resource('usuarios','UserController', ['except' => ['create','edit']]);
   Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

   Route::post('licencia', 'RegistroDatosController@licencia');
   Route::post('borrar_licencia', 'RegistroDatosController@borrar_licencia');
   
});