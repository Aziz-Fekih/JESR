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
Route::get('/unauthorized', function () {
    return response()->json('Non autorisé!', 401);
})->name('unauthorized');
//Route::get('/chat', function () {
//    return view('chat');
//});
//
////Route::post('/new/flow', 'FlowController@createConversation');
////Route::post('/sendMessage', 'FlowController@respond');
////Route::post('/testApp', 'DataFlowController@index');
////Route::post('/saveImages', 'DataFlowController@saveImages');
////
////Route::post('/communicate', 'DataFlowController@respond');
////
////Route::get('/getAttributes', 'DataFlowController@getAttributes');
////
////Route::get('/getConversation', 'DataFlowController@getConversation');
////
////
////Route::get('/testDialogflow', 'DialogflowController@index');
//
//Route::post('/auth/social/google', 'SocialLogin@loginGoogle');
//
//Route::get('login/google', 'LoginController@redirectToProvider');
//Route::get('login/google/callback', 'SocialLogin@loginGoogle');
//
//Route::post('sociallogin/{provider}', 'AuthController@SocialSignup');
//Route::get('auth/{provider}/callback', 'OutController@index')->where('provider', '.*');
//
////Route::get('testMessenger', 'MessengerController@Messenger');
//
//
////Route::post('/api/deployOnMessenger', 'DeployController@deployOnMessenger');


