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
        Route::post('/create-election', array('as'=>'Election.New','uses'=>'ElectionController@store'));
        Route::get('/election-view/{id?}', array('as'=>'Election.ViewOne','uses'=>'ElectionController@view'));
        Route::post('/assign-party', array('as'=>'Election.AssignParty','uses'=>'ElectionController@assignPartyToElection'));
    });

     //-- STATES ROUTES --//
    Route::group(['prefix' => 'state'], function () {
        Route::get('/view-states', array('as'=>'State.View','uses'=>'StateController@index'));
        Route::post('/activate', array('as'=>'State.Activate','uses'=>'StateController@activate'));
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
});

Auth::routes();
Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
});

