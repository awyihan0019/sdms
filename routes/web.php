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
Route::group(['middleware' => ['auth']], function() {
    // Route::resource('project/{project_id}', 'ProjectController');
    // Route::resource('issue', 'IssueController');
    Route::resource('comment', 'CommentController');
});

Route::patch('project/{project_id}/issue/store/{issue_id}', 'IssueController@update');

//Project Controller

Route::get('project/{project_id}', [
    'as' => 'currentProject', 'uses' => 'ProjectController@show'
]);

// Route::get('project/{project_id}', 'ProjectController@showIssue');

Route::post('/project/{project_id}/invite user', [
    'as' => 'storeMember', 'uses' => 'ProjectController@storeMember'
]);

//Issue Controller

Route::get('project/{project_id}/issue/index', [
    'as' => 'issue_index', 'uses' => 'IssueController@index'
]);

Route::get('project/{project_id}/issue/edit/{issue_id}', [
    'as' => 'issue_edit', 'uses' => 'IssueController@edit'
]);

Route::get('project/{project_id}//issue/show/{issue_id}', [
    'as' => 'issue_show', 'uses' => 'IssueController@show'
]);

Route::get('/issue/create/{project_id}', [
    'as' => 'issue_create', 'uses' => 'IssueController@create'
]);

//file upload and download

Route::post('project/{project_id}/issue/{issue_id}/attachFile', 'IssueController@attachFile');

Route::get('/attachFile/download/{id}', 'IssueController@download')->name('attachment.download');

//Comment

Route::get('project/{project_id}/issue/{issue_id}/comment', [
    'as' => 'add_comment', 'uses' => 'CommentController@create'
]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

