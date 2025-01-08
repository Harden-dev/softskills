<?php

use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategorieController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\GoogleAuthController;
use App\Http\Controllers\API\QuoteController;
use App\Http\Controllers\API\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v2')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->middleware(StartSession::class);
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->middleware(StartSession::class);

    Route::post('/contact', [ContactController::class, 'store']);
    Route::get('/contact/{id}', [ContactController::class, 'show']);
    Route::put('/update/contact /{id}', [ContactController::class, 'update']);
    Route::delete('/contact/delete/{id}', [ContactController::class, 'destroy']);
    

    Route::post('/quote', [QuoteController::class, 'store']);
    Route::get('/quote/list', [QuoteController::class, 'index']);
    Route::put('/quote/update/{id}', [QuoteController::class, 'update']);
    Route::delete('/quote/delete/{id}', [QuoteController::class, 'destroy']);

    Route::post('/subscription', [SubscriptionController::class, 'store']);
    Route::get('/subscription/list', [SubscriptionController::class, 'index']);
    Route::put('/update/subscription/{id}', [SubscriptionController::class, 'update']);
    Route::delete('/delete/subscription/{id}', [SubscriptionController::class, 'destroy']);

    Route::get('/published/articles', [ArticleController::class, 'publishedArticles']);
    


    // Routes protégées
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profil', [AuthController::class, 'me']);
        Route::get('/me/{slug}', [AuthController::class, 'show']);
        Route::post('/refresh', [AuthController::class, 'refresh']);

        Route::get('/articles/list', [ArticleController::class, 'index']);
        Route::get('/article/details/{slug}', [ArticleController::class, 'show']);

        Route::get('/article/{articleId}/comments', [CommentController::class, 'index']);
        Route::post('/add/comment/article/{articleId}', [CommentController::class, 'store']);
        Route::post('/reply/comment/{commentId}/article/{articleId}', [CommentController::class, 'reply']);
        Route::get('/replies/article/{articleId}/comment/{commentId}', [CommentController::class, 'getReplies']);
        Route::get('/comment/{id}', [CommentController::class, 'show']);
        Route::put('/update/comment/{id}', [CommentController::class, 'update']);
        Route::delete('/delete/comment/{id}', [CommentController::class, 'destroy']);
        

    });

    // Routes protégées uniquement pour les administrateurs

    Route::middleware(['auth:api', 'admin'])->group(function () {

        Route::get('/contact/list', [ContactController::class, 'index']);

        Route::post('/add/article', [ArticleController::class, 'store']);
        Route::put('/update/article/{id}', [ArticleController::class, 'update']);
        Route::delete('/delete/article/{id}', [ArticleController::class, 'destroy']);
        Route::get('/scheduled/articles', [ArticleController::class, 'scheduledArticles']);

        Route::post('add/category', [CategorieController::class, 'store']);
        Route::get('/category/list', [CategorieController::class, 'index']);
        Route::get('/category/{slug}', [CategorieController::class, 'show']);
        Route::put('/update/category/{id}',[CategorieController::class, 'update']);
        Route::delete('/delete/category/{id}', [CategorieController::class, 'destroy']);

        Route::get('/contact', [ContactController::class, 'index']);
        Route::put('/contact/update/{id}', [ContactController::class, 'update']);
        Route::get('/contact/{id}', [ContactController::class, 'show']);
        Route::delete('/contact/delete/{id}', [ContactController::class, 'destroy']);

    });
});
