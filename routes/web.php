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
//use Illuminate\Support\Facades\Http;
//$res = Http::get('https://www.tcmb.gov.tr/kurlar/today.xml');
//dump($res->body());die;

Route::view('/', 'welcome');

Route::get('/sample', function () {
    return view('sample', [
        'name' => 'Metin',
        'lastName' => 'Ozturk',
        'person' => ['name' => 'Merve Nur'],
    ]);
});
//
//Route::get('/f/{id}', function ($id){
//    echo $id;
//    return view('welcome');
//    //return redirect('/sample');
//});
//
//Route::redirect('/sample2','/f/302',302);

Route::get('main','MainController@index');
Route::get('/producer','MainController@producer');
Route::get('/consumer/{queue?}','MainController@consumer');
Route::get('/consumer-bind/{queue?}/{exchange?}','MainController@consumerBind');
Route::get('/consumer-unbind/{queue?}/{exchange?}','MainController@consumerUnBind');

Route::view('example', 'example');

Route::view('userview','user');
Route::post('usercontroller', 'UsersController@account');
