<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacebookInsightsController;
use App\Http\Controllers\GenerateFacebookTokenController;
use App\Http\Controllers\GeneratePageAccessTokenController;
use App\Http\Controllers\GenerateTwitterAccessTokenController;
use App\Http\Controllers\PostToFaceBookController;
use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public Route
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/tasks', [TasksController::class, 'index']);

// Protected Route
Route::group(['middleware' => ['auth:sanctum']], function() {
Route::post('/logout', [AuthController::class, 'logout']);
// FACEBOOK
Route::post('/getgeneratedtoken', [GenerateFacebookTokenController::class, 'generatetoken']);
Route::get('/getlonglivedtoken', [GenerateFacebookTokenController::class, 'GenerateLongLifeAccessToken']);


Route::get('/generatepageaccesstoken', [GeneratePageAccessTokenController::class, 'getfacebookpageaccesstoken']);

Route::post('/store_facebook_access_token', [GeneratePageAccessTokenController::class, 'StoreFBPageAccessToken']);
Route::get('/get_fb_page_access_token', [PostToFaceBookController::class, 'index']);


Route::post('/post_to_facebook', [PostToFaceBookController::class, 'PostToFaceBook']);
Route::post('/schedule_facebook_post', [PostToFaceBookController::class, 'SchedulePostToFacebook']);
Route::post('/publish_facebook_photo', [PostToFaceBookController::class, 'FacebookPublishPhoto']);
Route::post('/post_facebook_comment/{id}', [PostToFaceBookController::class, 'PostFacebookComments']);

Route::get('/post_facebook_userdetails', [GenerateFacebookTokenController::class, 'facebook_userdetails']);
Route::get('/get_facebook_userdetails', [GenerateFacebookTokenController::class, 'get_facebook_userdetails']);

Route::get('/get_single_facebook_page_impressions', [FacebookInsightsController::class, 'get_single_facebook_page_impressions']);

Route::get('/get_facebook_page_feed', [FacebookInsightsController::class, 'get_facebook_page_feed']);
Route::get('/get_facebook_feed_by_id/{id}', [FacebookInsightsController::class, 'get_facebook_feed_by_id']);

Route::get('/get_facebook_metrics', [FacebookInsightsController::class, 'get_facebook_matrics']);
Route::get('/get_facebook_pageid', [GeneratePageAccessTokenController::class, 'getFacebookPageId']);

Route::get('/get_facebook_page_access_details', [GeneratePageAccessTokenController::class, 'getFacebookPageAccessDetails']);
Route::get('/get_facebook_comments/{id}', [PostToFaceBookController::class, 'FetchFacebookComments']);



// TWITTER ( NOT WORKING)
Route::post('/generate_twitter_oauth_token', [GenerateTwitterAccessTokenController::class, 'index']);
});


