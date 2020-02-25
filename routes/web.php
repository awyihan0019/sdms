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

Route::resource('project', 'ProjectController');

Route::resource('issue', 'IssueController');

Route::resource('comment', 'CommentController');

//Project Controller

Route::get('/project/add_member/{project_id}', [
    'as' => 'add_member', 'uses' => 'ProjectController@addMember'
]);

Route::post('/project/store_member/{project_id}', [
    'as' => 'store_member', 'uses' => 'ProjectController@storeMember'
]);

Route::get('project/{id}', [
    'as' => 'currentProject', 'uses' => 'ProjectController@show'
]);

Route::get('project/{id}', 'ProjectController@showIssue');

//Issue Controller

Route::get('/issue/index/{project_id}', [
    'as' => 'issue_index', 'uses' => 'IssueController@index'
]);

Route::get('/issue/edit/{issue_id}', [
    'as' => 'issue_edit', 'uses' => 'IssueController@edit'
]);

Route::get('/issue/show/{issue_id}', [
    'as' => 'issue_show', 'uses' => 'IssueController@show'
]);

Route::get('/project/create_issue/{project_id}', [
    'as' => 'create_issue', 'uses' => 'IssueController@create'
]);

Route::post('/attachFile/{id}', 'IssueController@attachFile');



Route::get('/issue/comment/{issue_id}', [
    'as' => 'add_comment', 'uses' => 'CommentController@create'
]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

