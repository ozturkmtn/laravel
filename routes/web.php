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

Route::get('/sample', function () {
    return view('sample', ['name' => 'John']);
});
//
//Route::get('/f/{id}', function ($id){
//    echo $id;
//    return view('welcome');
//    //return redirect('/sample');
//});
//
//Route::redirect('/sample2','/f/302',302);

//Route::get('main','MainController@index');

Route::view('example', 'example');
