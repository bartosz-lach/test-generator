<?php

use App\Http\Controllers\TestController;
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


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::get('tests/join', 'TestController@join');
Route::put('tests/{test}/full', 'TestController@updateFullTest');

Route::middleware(['auth:api'])->group(function (){

    //Tests routing
    Route::get('tests', 'TestController@index');
    Route::post('tests', 'TestController@store');
    Route::post('tests/full', 'TestController@storeFullTest');
    Route::get('tests/{test}', 'TestController@show')->middleware('can:access,test');
    Route::get('tests/{test}/full', 'TestController@showFullTest')->middleware('can:access,test');
    Route::put('tests/{test}/full', 'TestController@updateFullTest')->middleware('can:access,test');
    Route::put('tests/{test}', 'TestController@update')->middleware('can:access,test');
    Route::delete('tests/{test}', 'TestController@destroy')->middleware('can:access,test');
    Route::get('tests/{test}/subject/{subject}', 'TestController@testsBySubject')->middleware('can:access,test');

    //Questions routing
    Route::get('tests/{test}/questions', 'QuestionController@index')->middleware('can:access,test');
    Route::post('tests/{test}/questions', 'QuestionController@store')->middleware('can:access,test');
    Route::get('questions/{question}', 'QuestionController@show')->middleware('can:access,question');
    Route::put('questions/{question}', 'QuestionController@update')->middleware('can:access,question');
    Route::delete('questions/{question}', 'QuestionController@destroy')->middleware('can:access,question');

    //Answers routing
    Route::get('questions/{question}/answers', 'AnswerController@index')->middleware('can:access,question');
    Route::post('questions/{question}/answers', 'AnswerController@store')->middleware('can:access,question');
    Route::get('answers/{answer}', 'AnswerController@show')->middleware('can:access,answer');
    Route::put('answers/{answer}', 'AnswerController@update')->middleware('can:access,answer');
    Route::delete('answers/{answer}', 'AnswerController@destroy')->middleware('can:access,answer');

    //TestVersion routing
    Route::get('tests/{test}/test-versions', 'TestVersionController@index')->middleware('can:access,test');
    Route::post('tests/{test}/generate', 'TestVersionController@generateTestVersion')->middleware('can:access,test');
    Route::get('test-versions/{testVersion}', 'TestVersionController@show')->middleware('can:accessToTestVersion,testVersion');
    Route::delete('test-versions/{testVersion}', 'TestVersionController@destroy')->middleware('can:accessToTestVersion,testVersion');

    //Subject routing
    Route::resource('subjects', 'SubjectController');

    //PDF generate
    Route::get('/test-versions/{testVersion}/pdf/test', 'TestVersionController@generateTestPdf')->middleware('can:accessToTestVersion,testVersion');
    Route::get('/test-versions/{testVersion}/pdf/questions-sheet', 'TestVersionController@generateQuestionSheetPdf')->middleware('can:accessToTestVersion,testVersion');
    Route::get('/test-versions/{testVersion}/pdf/check-sheet', 'TestVersionController@generateCheckSheetPdf')->middleware('can:accessToTestVersion,testVersion');

});




