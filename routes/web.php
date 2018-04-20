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

Route::get('/',function() {
    // display index page
    if (Auth::check()) {
      return view('/dashboard');
    }
    return view('auth.login');
});

//
Auth::routes();

// dashboard
Route::get('dashboard', function() {
  return view('/dashboard');
})->middleware('auth');


// users
Route::resource('users','UsersController');
// departments
Route::resource('departments','DepartmentsController');
// categories
Route::resource('categories','CategoriesController');
Route::delete('categoriesDeleteMulti', 'CategoriesController@deleteMulti');
// documents
Route::resource('documents','DocumentsController');
Route::get('documents/download/{id}','DocumentsController@download');
Route::get('documents/open/{id}','DocumentsController@open');
Route::get('mydocuments','DocumentsController@mydocuments');
Route::get('/trash','DocumentsController@trash');
Route::get('documents/restore/{id}','DocumentsController@restore');
Route::delete('documentsDeleteMulti','DocumentsController@deleteMulti');
// search
Route::post('/search','DocumentsController@search');
// sort
Route::post('/sort', 'DocumentsController@sort');
// shared
Route::resource('shared','ShareController');
// roles and permissions
Route::resource('roles','RolesController');
// profile
Route::resource('profile','ProfileController');
Route::patch('profile','ProfileController@changePassword');
// registeration requests
Route::resource('requests','RequestsController');
// backup
Route::get('backup','BackupController@index');
Route::get('backup/create','BackupController@create');
Route::get('backup/download','BackupController@download');
Route::get('backup/delete','BackupController@delete');
// log
Route::get('logs','LogController@log');
Route::get('logsdel','LogController@logdel');
