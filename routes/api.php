<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', 'UserController@login');


Route::apiResource('category','CategoryController');
Route::get('category/length/{category}', 'CategoryController@articles_length');
Route::resource('category', 'CategoryController');

//Delete member from project
Route::apiResource('project','ProjectController');
Route::get('project/deleteMember/{project}/{member}', 'ProjectController@deleteMember');
Route::resource('project', 'ProjectController');

//Add member to project
Route::apiResource('project','ProjectController');
Route::get('project/addMember/{project}/{member}', 'ProjectController@addMember');
Route::resource('project', 'ProjectController');




Route::apiResource('article','ArticleController');

Route::apiResource('wiki','WikiController');

Route::apiresource('permission','PermissionController');

Route::apiResource('role','RoleController');

Route::apiResource('user', 'UserController');

Route::apiResource('document', 'DocumentController');


