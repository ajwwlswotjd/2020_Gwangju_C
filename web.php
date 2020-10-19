<?php 

use Gondr\Route;

Route::get("/", "PageController@index");
Route::get("exchangeRate", "PageController@exchangeRate");
Route::get("festival" , "PageController@rep_festival");
Route::get("notice" , "PageController@notice");

Route::get("user_join","PageController@join");
Route::get("user_login","PageController@login");
Route::get("user_logout" , "UserController@logout");

Route::get("download" , "DataController@download");

Route::get("init", "DataController@init");





Route::post("user/login","UserController@login");

Route::post("api/get/festival" , "APIController@getFestivals");