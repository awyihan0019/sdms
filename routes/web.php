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

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/project/create_issue/{project_id}', [
    'as' => 'create_issue', 'uses' => 'IssueController@create'
]);

Route::get('/project/add_member/{project_id}', [
    'as' => 'add_member', 'uses' => 'ProjectController@addMember'
]);

Route::post('/project/store_member/{project_id}', [
    'as' => 'store_member', 'uses' => 'ProjectController@storeMember'
]);


Route::get('/issue/index/{project_id}', [
    'as' => 'issue_index', 'uses' => 'IssueController@index'
]);

Route::get('/issue/edit/{issue_id}', [
    'as' => 'issue_edit', 'uses' => 'IssueController@edit'
]);

Route::get('project/{id}', [
    'as' => 'currentProject', 'uses' => 'ProjectController@show'
]);

Route::get('/issue/comment/{issue_id}', [
    'as' => 'add_comment', 'uses' => 'CommentController@create'
]);

Route::get('project/{id}', 'ProjectController@showIssue');

// Route::get('/issue/{issue_id}/comment', [
//     'as' => 'comment', 'uses' => 'CommentController@create'
// ]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

