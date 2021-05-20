<?php

use Illuminate\Support\Facades\Route;

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



//ovako nesto bi trebalo odraditi da mi se ne prikazuje id unutrar urla, nego da bude ovaj slug
Route::get('/{slug}', function($slug){
    
    $post = App\Models\Post::where($slug)->first();
    
    return view('post', ['post'=>$post]);
});
