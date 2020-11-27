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

Route::get('login', 'LoginController@index')->name('login');
Route::post('login', 'LoginController@login');
Route::middleware(['auth'])->group(function () {
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('groups', 'GroupsController');
    Route::get('personal', 'LoginController@personal')->name('personal');
    Route::get('logout', 'LoginController@logout');
    Route::get('profile/{user}', 'Ekeng\ProfileController@index');
    Route::patch('update_personal/{user}', 'Ekeng\ProfileController@update')->name('update_personal');
    Route::patch('change_password/{user}', 'Ekeng\ProfileController@change')->name('change_password');
    Route::post('permissions_foreach', 'PermissionController@foreach')->name('permissions_foreach');
    Route::resource('pages','PageController');
    Route::post('pages/delete', 'PageController@delete');
    Route::get('pages/edit/{id}','PageController@edit');
    Route::get('all_pages','PageController@index');

    Route::get('menu','MenuController@index');
    Route::get('menu/builder/{id}','MenuController@build');
    Route::get('menu/builder/edit/{id}','MenuController@build_edit'); //ajax
    Route::post('menu/create', 'MenuController@create')->name('menu_create');
    Route::post('menu/create/menu_item', 'MenuController@create_menu_item')->name('menu_item');
});



MenuBuilder::routes();
