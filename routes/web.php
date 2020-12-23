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
    Route::resource('categories', 'CategoryController');
    Route::post('categories_foreach', 'CategoryController@foreach');
    Route::resource('posts', 'PostController');
    Route::post('posts_foreach', 'PostController@foreach')->name('posts_foreach');
    Route::post('posts_search', 'PostController@search')->name('posts_search');
    Route::get('personal', 'LoginController@personal')->name('personal');
    Route::get('logout', 'LoginController@logout');
    Route::get('profile/{user}', 'Ekeng\ProfileController@index');
    Route::patch('update_personal/{user}', 'Ekeng\ProfileController@update')->name('update_personal');
    Route::patch('change_password/{user}', 'Ekeng\ProfileController@change')->name('change_password');
    Route::post('permissions_foreach', 'PermissionController@foreach')->name('permissions_foreach');
    Route::resource('pages','PageController');
    Route::post('pages_foreach', 'PageController@foreach');

    Route::get('menu','MenuController@index');
    Route::post('menus_foreach','MenuController@foreach');
    Route::get('menu/edit/{id}', 'MenuController@edit')->name('menu_edit');
    Route::delete('menu/delete/{id}', 'MenuController@delete')->name('menu_delete');
    Route::get('menu/builder/{id}','MenuItemController@build')->name('menu_builder');
    Route::get('menu/builder/edit/{id}','MenuItemController@build_edit'); //ajax
    Route::post('menu/create', 'MenuItemController@create')->name('menu_create');
    Route::post('menu/create/menu', 'MenuController@create_menu')->name('create_menu');
    Route::post('menu/menu_item_add', 'MenuItemController@menu_item_add')->name('menu_item_add');
    Route::post('menu/menu_item_edit', 'MenuItemController@menu_item_edit')->name('menu_item_edit');
    Route::post('menu/menu_item_delete', 'MenuItemController@menu_item_delete')->name('menu_item_delete');
    Route::get('menu/builder/edit/get_page/{id}','MenuItemController@get_page'); //ajax
});
