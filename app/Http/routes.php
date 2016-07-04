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
Route::group(['middleware' => 'auth'], function () {
	Route::get('/', 'HomeController@index')->name('dashboard.index');
	Route::get('questionnaire/changePosition/{type}-{id}', 'QuestionnaireController@ChangePosition');
	Route::get('questionnaire/flushQuestion', 'QuestionnaireController@flushQuestionCache')->name('questionnaire.flush');
	Route::resource('questionnaire', 'QuestionnaireController');
	Route::resource('alumni', 'AlumniController');
	Route::get('feedback', 'FeedbackController@index')->name('feedback.index');
	Route::get('deleteConfirmation/{route}/{id}', 'HomeController@modalDelete');
	Route::get('account/create/{type}', 'AccountController@create');
	Route::post('account', 'AccountController@store');

	Route::group(['prefix' => 'report'], function () {
		Route::get('/', 'ReportController@index')->name('reporting.index');
	});

	Route::group(['prefix' => 'monitoring'], function () {
		Route::get('alumni', 'AlumniController@recent')->name('monitoring.alumni');
		Route::get('feedback', 'FeedbackController@recent')->name('monitoring.feedback');
		Route::resource('questionnaire', 'QuestionnaireResponseController', ['only' => ['index', 'show']]);
	});
});

Route::auth();