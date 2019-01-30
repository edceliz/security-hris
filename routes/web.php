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

Auth::routes();

Route::group(['middleware' => ['web', 'auth']], function() {
  // Dashboard - Authorization Levels: 1, 2, 3
  Route::get('/', 'HomeController@index');
  Route::get('/list/{type}/{id}', 'HomeController@show');
  // TEMPORARY DISABLED
  // Route::get('/memo/{id}/{type}', 'HomeController@memo');

  // Users - Authorization Levels: 1
  Route::prefix('/users')->middleware('can:manage-users')->group(function() {
    Route::get('/', 'UserController@index');
    Route::get('/new', 'UserController@create');
    Route::get('/{id}', 'UserController@edit');

    Route::post('/new', 'UserController@store');
    Route::post('/delete/{id}', 'UserController@destroy');
    Route::post('/{id}', 'UserController@update');
  });
  
  // Employees - Authorization Levels: 1, 2, 3
  Route::prefix('/employees')->group(function() {
    Route::get('/', 'EmployeeController@index');
    Route::get('/search', 'EmployeeController@search');
    
    // Employees CUD - Authorization Levels: 1, 2
    Route::group(['middleware' => ['can:manage-employees']], function() {
      Route::get('/new', 'EmployeeController@create');
      Route::get('/job/{id}', 'JobController@edit');
      Route::get('/license/{id}', 'SecurityLicenseController@edit');
      Route::get('/edit/{id}', 'EmployeeController@edit');

      Route::post('/', 'EmployeeController@store');
      Route::post('/delete/{id}', 'EmployeeController@destroy');
      Route::post('/edit/{id}', 'EmployeeController@update');
      Route::post('/license/{id}', 'SecurityLicenseController@store');
      Route::post('/job/status/{id}', 'StatusController@update');
      Route::post('/job/detachment/{id}', 'EmployeeDetachmentController@update');
      Route::post('/job/position/{id}', 'PositionController@update');
    });

    Route::get('/{id}', 'EmployeeController@show');
  });

  // Detachments - Authorization Levels: 1, 2, 3
  Route::prefix('/detachments')->group(function() {
    Route::get('/', 'DetachmentController@index');
    Route::get('/search', 'DetachmentController@search');
    // Detachments CUD - Authorization Levels: 1
    Route::group(['middleware' => ['can:manage-detachments']], function() {
      Route::get('/new', 'DetachmentController@create');
      Route::get('/{id}', 'DetachmentController@edit');

      Route::post('/', 'DetachmentController@store');
      Route::post('/{id}', 'DetachmentController@update');
      Route::post('/delete/{id}', 'DetachmentController@destroy');
    });
  });
  
  // Report Module - Authorization Levels: 1, 2, 3
  Route::prefix('/report')->group(function() {
    Route::get('/', 'ReportController@index');
    // Route::get('/generate', 'ReportController@show');
    Route::get('/generate/{type}', 'ReportController@show');
  });

  // Own Account - Authorization Levels: 1, 2, 3
  Route::get('/account', 'AccountController@index');
  Route::post('/account/{id}', 'AccountController@update');
});
