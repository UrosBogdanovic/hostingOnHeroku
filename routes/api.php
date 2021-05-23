<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\User;
use App\Models\CompanyData;
use App\Http\Controllers\CompanyDataController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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
//OVAKO IZGLEDA SINTAKSA ZA LARAVEL 8 ukoliko ne zelim da kucam za svaku akciju pojedinacno. Npr da pravim get/post/put/delete pa kazem koju metodu pozivam...
Route::ApiResource('posts', PostController::class);
Route::ApiResource('users', UserController::class);
Route::ApiResource('companyData', CompanyDataController::class);

//Route::get('/companyData/details/{username}', [CompanyDataController::class, 'userDetail']);
Route::get('/companyData/joinDetails/{username}', [CompanyDataController::class, 'joinDetails']);
Route::get('/companyData/companyName/{username}', [CompanyDataController::class, 'getAllUserDetails']);
Route::post('/user-login', [CompanyDataController::class, 'userLogin']);

Route::get('/posts/getAllPostsForUser/{username}', [PostController::class, 'getAllPostsForUser']);



//Route::get('/posts',function(){
//    $post = Post::create([
//        'title'=>'my first post',
//        'slug'=>'my-first-post'
//        ]);
//    return $post;
//});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
