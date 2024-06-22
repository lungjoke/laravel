<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
    
});


Route::get('about',function(){
return"About page";
});

//Route แบบมีการส่ง param
Route::get('user/{name}',function($name){
    return"Hello".$name;
});

//Route post
Route::post('prodect',function(){
    return"This is my product";
});
