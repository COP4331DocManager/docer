<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return File::get(public_path() . '/index.html');
});

Route::group(['prefix' => 'api'], function()
{
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::get('home', 'HomeController@index');

    // Handles registering
    Route::post('register', 'AuthenticateController@register');

    // Handle logout
    Route::get('deauthenticate', 'AuthenticateController@deauthenticate');

    Route::resource('test', 'TestController', ['only' => ['index']]);

    Route::controller('system', 'SystemController');

    Route::post('document', 'DocumentController@upload');
    Route::get('document/{id}', 'DocumentController@view');
    Route::get('document/{id}/info', 'DocumentController@info');
    Route::post('document/{id}/update', 'DocumentController@update');
    Route::delete('document/{id}', 'DocumentController@delete');
    Route::post('search', 'DocumentController@search');


    // Admin Routes
    Route::get('/get-system-info', 'AdminController@getSystemInfo');
    Route::get('/get-admin-page-info', 'AdminController@getAdminPageInfo');


    // Users api endpoints
    Route::post('/create-user', 'UserController@createUser');
    Route::get('/read-user', 'UserController@readUser');
    Route::post('/update-user', 'UserController@updateUser');
    Route::post('/destroy-user', 'UserController@destroyUser');

    // Documents api endpoints
    Route::post('/create-document', 'DocumentController@createDocument');
    Route::get('/read-document', 'DocumentController@readDocument');
    Route::post('/update-document', 'DocumentController@updateDocument');
    Route::post('/destroy-document', 'DocumentController@destroyDocument');


    // Groups api end points
    Route::post('/create-group', 'GroupController@createGroup');
    Route::get('/read-group', 'GroupController@readGroup');
    Route::get('/get-group-members', 'GroupController@getGroupMembers');
    Route::get('/get-group-documents', 'GroupController@getGroupDocuments');
    Route::post('/add-member', 'GroupController@addMember');
    Route::post('/delete-member', 'GroupController@deleteMember');
    Route::post('/destroy-group', 'GroupController@destroyGroup');
    Route::post('/promote-member', 'GroupController@updateGroupAdmins');

});

Route::auth();

Route::get('/home', 'HomeController@index');
