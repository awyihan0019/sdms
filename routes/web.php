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

Route::get('/', function () {
    return view('welcome');
});

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::resource('project', 'ProjectController');

Route::resource('issue', 'IssueController');

Route::get('/issue/create/{project_id}', [
    'as' => 'issue_create', 'uses' => 'IssueController@create'
]);

Route::get('project/create_issue', 'IssueController@create');

Route::get('/issue/index/{project_id}', [
    'as' => 'issue_index', 'uses' => 'IssueController@index'
]);

Route::get('project/{id}', 'ProjectController@show');

Route::get('project/{id}', 'ProjectController@showIssue');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

