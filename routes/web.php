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
Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware'=>['auth']], function(){
    Route::get('/dashboard', array('as'=>'Dashboard','uses'=>'DashboardController@index'));
    
    //-- ELECTION ROUTES --//
    Route::group(['prefix' => 'election'], function () {
        Route::get('/overview', array('as'=>'Election.View','uses'=>'ElectionController@index'));
        Route::post('/create-election', array('as'=>'Election.New','uses'=>'ElectionController@store'));
        Route::get('/election-view/{id?}', array('as'=>'Election.ViewOne','uses'=>'ElectionController@view'));
        Route::get('/submitted-result/{id?}', array('as'=>'SubmittedResult','uses'=>'ElectionController@viewSubmittedResult'));
        Route::get('/win-metrics/{id?}', array('as'=>'winMetric','uses'=>'ElectionController@winMetricIndex'));
        Route::get('/passcode-view/{id?}', array('as'=>'PasscodeView','uses'=>'ElectionController@passcodeView'));
        Route::get('/infographics-view/{id?}', array('as'=>'InfographicView','uses'=>'ElectionController@InfographicView'));
        Route::post('/ajax-calls', array('as'=>'ElectionAjax','uses'=>'ElectionController@AjaxProcess'));
        Route::post('/change-status', array('as'=>'Election.ChangeStatus','uses'=>'ElectionController@changeStatus'));
        Route::post('/check-passcode', array('as'=>'CheckPasscode','uses'=>'ElectionController@checkPasscode'));
        Route::put('/submit-result', array('as'=>'SubmitResult','uses'=>'ElectionController@submitResult'));
        Route::post('dashboard-stats', array('as'=>'Election.Stats','uses'=>'ElectionController@showStats'));
        Route::post('query-api', array('as'=>'QueryApi','uses'=>'ElectionController@queryResult'));
        Route::get('/reports/{id?}', array('as'=>'view.reports','uses'=>'ElectionController@reportsIndex'));
        Route::get('/activity-logs/{id?}', array('as'=>'view.activity','uses'=>'ElectionController@activityLogIndex'));
        Route::get('/broadsheet/{id?}', array('as'=>'Election.broadsheet','uses'=>'ElectionController@broadsheetIndex'));
        Route::post('/mark-as-star-party', array('as'=>'MarkStar','uses'=>'ElectionController@markStar'));

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
        Route::post('/update-user', array('as'=>'Users.update','uses'=>'UsersController@update'));
        Route::delete('/delete-user', array('as'=>'Delete.User','uses'=>'UsersController@destroy'));
    });

    Route::group(['prefix' => 'polling-stations'], function () {
        Route::get('/', array('as'=>'polling.index','uses'=>'PollingCentreController@index'));
        Route::get('/ajax-state',array('as' => 'polling.ward' ,'uses' => 'PollingController@ward'));
        Route::post('/store', array('as'=>'polling.store','uses'=>'PollingController@store'));
        Route::post('/update', array('as'=>'polling.update','uses'=>'PollingController@update'));
        Route::delete('/delete', array('as'=>'Delete.polling','uses'=>'PollingController@destroy'));
        Route::post('/get-lgas', array('as'=>'getLga','uses'=>'PollingCentreController@getLga'));
        Route::post('/get-wards', array('as'=>'getWard','uses'=>'PollingCentreController@getWard'));
        Route::post('/get-polling-stations', array('as'=>'getPollingStation','uses'=>'PollingCentreController@getPollingStations'));
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', array('as'=>'roles.index','uses'=>'RoleController@index'));
        Route::post('/store', array('as'=>'roles.store','uses'=>'RoleController@store'));
        Route::post('/update', array('as'=>'roles.update','uses'=>'RoleController@update'));
        Route::post('/assign_permission', array('as'=>'roles.assign_permission','uses'=>'RoleController@assign_permission'));
        Route::delete('/delete', array('as'=>'Delete.assign_roles','uses'=>'RoleController@destroy'));
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
        Route::get('/preferences', array('as'=>'preference.index','uses'=>'PreferencesController@index'));
        Route::post('/bulk-upload', array('as'=>'preference.uploadStore','uses'=>'PreferencesController@storeBulkUpload'));
        Route::post('/preferences', array('as'=>'preferenceUpdate','uses'=>'PreferencesController@store'));
    });
});

Auth::routes();
Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
});

