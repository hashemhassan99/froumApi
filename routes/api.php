<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(["prefix" => "v1","namespace" => "API"],function ($router){

    // below routes are public
    Route::group(["prefix"=>"auth"],function (){
        //create anew user
        Route::post("register","AuthController@register");
        //login user
        Route::post('login', 'AuthController@login');
        // refresh jwt token
        Route::post('refresh', 'AuthController@refresh');
    });

    //below routes are restricted
    Route::group(['middleware'=>'auth:api',"prefix" =>"auth"],function (){
        //logout user
        Route::post('logout','AuthController@logout');
        //get user info
        Route::get('user','AuthController@user');


       // Route::get('user','AuthController@user');


    });
    Route::apiResource('channels','ChannelController');
    Route::apiResource('discussions','DiscussionController');
    Route::apiResource('replies','ReplyController');

});

