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
    /** worked on this (Austin) **/
    Route::group(['prefix' => 'users'], function () {
        Route::get('/view-users', array('as'=>'Users.View','uses'=>'UsersController@index'));
        Route::post('/create-user', array('as'=>'Users.New','uses'=>'UsersController@store'));
        Route::post('/update-user', array('as'=>'Users.update','uses'=>'UsersController@update'));
        Route::delete('/delete-user', array('as'=>'Delete.User','uses'=>'UsersController@destroy'));
    });

    Route::group(['prefix' => 'ward'], function () {
        Route::get('/', array('as'=>'ward.index','uses'=>'WardController@index'));
        Route::get('/ajax-state',array('as' => 'ward.lga' ,'uses' => 'WardController@state_lga'));
        Route::post('/store', array('as'=>'ward.store','uses'=>'WardController@store'));
        Route::post('/update', array('as'=>'ward.update','uses'=>'WardController@update'));
        Route::delete('/delete', array('as'=>'Delete.ward','uses'=>'WardController@destroy'));
    });
    Route::group(['prefix' => 'polling'], function () {
        Route::get('/', array('as'=>'polling.index','uses'=>'PollingController@index'));
        Route::get('/ajax-state',array('as' => 'polling.ward' ,'uses' => 'PollingController@ward'));
        Route::post('/store', array('as'=>'polling.store','uses'=>'PollingController@store'));
        Route::post('/update', array('as'=>'polling.update','uses'=>'PollingController@update'));
        Route::delete('/delete', array('as'=>'Delete.polling','uses'=>'PollingController@destroy'));
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', array('as'=>'roles.index','uses'=>'RoleController@index'));
        Route::post('/store', array('as'=>'roles.store','uses'=>'RoleController@store'));
        Route::post('/update', array('as'=>'roles.update','uses'=>'RoleController@update'));
        Route::post('/assign_permission', array('as'=>'roles.assign_permission','uses'=>'RoleController@assign_permission'));
        Route::delete('/delete', array('as'=>'Delete.assign_roles','uses'=>'RoleController@destroy'));
    });
    /** Stop here for now **/ 
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

