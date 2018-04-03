<?php

use Illuminate\Http\Request;

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
Route::group(['prefix' => 'v1'], function() {
	//api route for check/validating election token
	Route::post('/login', 'API\CheckElectionController@store');
	Route::post('/election-details', 'API\SubmitResultController@index');
	Route::post('/parties', 'API\CheckElectionController@getParties');

	//api route for submit election result
	Route::get('election-types', 'API\SubmitResultController@index');
	Route::get('states', 'API\SubmitResultController@loadStates');
	Route::post('constituency', 'API\SubmitResultController@viewConstituency');
	Route::post('lga', 'API\SubmitResultController@viewLga');
	Route::post('ward', 'API\SubmitResultController@viewWard');
	Route::post('polling-centres', 'API\SubmitResultController@viewCentres');
	Route::post('submit-result', 'API\SubmitResultController@store');
	Route::post('submit-reports', 'API\SubmitResultController@storeReports');
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
