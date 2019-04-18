<?php

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

Route::get('/', 'HomeController@RootFolder' );
Route::get('folder/{id}', 'HomeController@folder');
Route::post('/setRootFolder','HomeController@setRootFolder' );

//ajax functions..
Route::get('ajax/savedirectoryimage', 'AjaxController@savedirectoryimage');
Route::get('ajax/folderorder', 'AjaxController@folderorder');

//test function
Route::get('lauraistesting', 'ServerController@lauraistesting' );