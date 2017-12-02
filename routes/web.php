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

Route::group(['middleware'=>['auth']], function(){
    Route::get('/dashboard', array('as'=>'Dashboard','uses'=>'HomeController@index'));
    Route::get('/', 'HomeController@index')->name('home');
    
    //-- ELECTION ROUTES --//
    Route::group(['prefix' => 'election'], function () {
        Route::get('/overview', array('as'=>'Election.View','uses'=>'ElectionController@index'));
        // Route::get('/add-election', array('as'=>'ElectionNew','uses'=>'ElectionController@indexNew'));
        Route::post('/create-election', array('as'=>'Election.New','uses'=>'ElectionController@store'));
        Route::get('/election-view/{id?}', array('as'=>'Election.ViewOne','uses'=>'ElectionController@view'));
        Route::post('/assign-party', array('as'=>'Election.AssignParty','uses'=>'ElectionController@assignPartyToElection'));
        Route::post('/ajax-calls', array('as'=>'ElectionAjax','uses'=>'ElectionController@AjaxProcess'));
    });

    //-- STATES ROUTES --//
    Route::group(['prefix' => 'state'], function () {
        Route::get('/view-states', array('as'=>'State.View','uses'=>'StateController@index'));
        Route::post('/activate', array('as'=>'State.Activate','uses'=>'StateController@activate'));
    });

    //-- LGA ROUTES --//
    Route::group(['prefix' => 'lga'], function () {
        Route::get('/index', array('as'=>'lga.View','uses'=>'LGAController@index'));
    });

    //-- USERS ROUTES --//
    Route::group(['prefix' => 'users'], function () {
        Route::get('/view-users', array('as'=>'Users.View','uses'=>'UsersController@index'));
        Route::post('/create-user', array('as'=>'Users.New','uses'=>'UsersController@store'));
    });

    //-- POLITICAL PARTIES ROUTES --//
    Route::group(['prefix' => 'political-parties'], function () {
        Route::get('/', array('as'=>'PP.View','uses'=>'PoliticalPartyController@index'));
        Route::get('/view/{id?}', array('as'=>'PP.Edit','uses'=>'PoliticalPartyController@show'));
        Route::post('/create-political-party', array('as'=>'PP.New','uses'=>'PoliticalPartyController@store'));
    });

    //-- SETTINGS & PREFERENCES ROUTES --//
    Route::group(['prefix' => 'preferences'], function () {
        Route::get('/', array('as'=>'preference.uploadView','uses'=>'PreferencesController@bulkUploadindex'));
        Route::post('/bulk-upload', array('as'=>'preference.uploadStore','uses'=>'PreferencesController@storeBulkUpload'));
    });
});

Auth::routes();
Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
});

