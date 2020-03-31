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

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/logout', 'AuthController@logout');




    Route::post('/association', 'AssociationController@createAssociation');
    Route::put('/association/{association}', 'AssociationController@updateAssociation');
    Route::delete('/association/{association}', 'AssociationController@deleteAssociation');

    Route::put('/updatePassword/{user}', 'UserController@updatePassword');
    Route::post('/register', 'AuthController@register');
    Route::put('/users/{user}', 'UserController@updateUser');
    Route::delete('/users/{user}', 'UserController@deleteUser');
    



    Route::put('/don/{don}', 'DonController@updateDon');
    Route::delete('/don/{don}', 'DonController@deleteDon');


    Route::post('/article', 'ArticleController@createArticle');
    Route::put('/article/{article}', 'ArticleController@updateArticle');
    Route::delete('/article/{article}', 'ArticleController@deleteArticle');
});


Route::post('/login', 'AuthController@login');




//Crud Dons
Route::post('/don', 'DonController@createDon');
Route::get('/don/{don}', 'DonController@getDon');
Route::get('/don', 'DonController@getDons');

Route::put('/affecterActeur/{don}', 'DonController@setActeur');
Route::get('/getLastWeekDons', 'DonController@getLastWeekDons');




//Crud Users
Route::get('/users/{user}', 'UserController@getUser');
Route::get('/users', 'UserController@getUsers');

Route::get('/getaffecteddons/{user}', 'UserController@getDons');
Route::get('/acteurs', 'UserController@getActeurs');


//Crud Associations
Route::get('/association/{association}', 'AssociationController@getAssociation');
Route::get('/association', 'AssociationController@getAssociations');


//Crud Articles
Route::get('/article/{article}', 'ArticleController@getArticle');
Route::get('/article', 'ArticleController@getArticles');

 






// Route::post('/gouvernorats', 'AssociationController@addGouvernorats');

