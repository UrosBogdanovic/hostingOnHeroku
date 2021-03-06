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
//Route::middleware('auth:api')->get('/user', function(Request $request) {
//    return $request->user();
//});
//
//Route::middleware(['api'])->group(function ($router) {
//    Route::ApiResource('users', UserController::class);
//   
//    Route::ApiResource('companyData', CompanyDataController::class);
//   
//});

Route::ApiResource('users', UserController::class);

Route::ApiResource('companyData', CompanyDataController::class);

Route::post('user-login', [CompanyDataController::class, 'userLogin']);
Route::ApiResource('posts', PostController::class);

//Route::get('/companyData/details/{username}', [CompanyDataController::class, 'userDetail']);
//Route::get('/companyData/joinDetails/{username}', [CompanyDataController::class, 'joinDetails']); // ne koristim
Route::get('/companyData/companyName/{username}/{token}', [CompanyDataController::class, 'getAllUserDetails']);


Route::get('/posts/getAllPostsForCompany/{username}/{token}', [PostController::class, 'getAllPostsForCompany']); // company/{id}/posts

Route::put('/posts/update1/{id}/{token}', [PostController::class, 'update1']); //posts/{id}
Route::post('/posts/create/{token}', [PostController::class, 'create']); //posts/{id}
Route::delete('/posts/delete/{id}/{token}', [PostController::class, 'delete']); //posts/{id}

Route::get('/posts/getAllPostsForUser/{id}/{token}', [PostController::class, 'getAllPostsForUser']); //users/{id}/posts/
//registracija

Route::post('/user-registration', [CompanyDataController::class, 'registration']);

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
