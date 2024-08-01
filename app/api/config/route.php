<?php

use Webman\Route;

use app\middleware\RequestApiAuthCheckMiddleware;

use app\api\controller\TestController;

use app\api\controller\PostController;
use app\api\controller\UserController;
use app\api\controller\MainDynamicController;


Route::get('/api/test', [TestController::class, 'test']);

Route::group('/api', function () {
    Route::group('/main-dynamic', function () {

        /**
         * 关注模块
         */
        Route::group('/follow', function () {
            Route::get("/post", [MainDynamicController::class, 'postFollowList']);
        });

        /**
         * 推荐模块
         */
        Route::group("/recommend", function () {
            Route::get("/banner", [MainDynamicController::class, 'bannerList']);
            Route::get("/post", [MainDynamicController::class, 'postList']);
        });

    });

    Route::group('/post', function () {
        Route::post('', [PostController::class, 'create']);
        Route::get('/{id:\d+}', [PostController::class, 'detail']);
        Route::post('/reply', [PostController::class, 'createReplyMessage']);
        Route::get('/reply/{id:\d+}', [PostController::class, 'replyMessage']);

        Route::put('/like', [PostController::class, 'like']);
    });

    Route::group('/user', function () {
        Route::put('/follow', [UserController::class, 'follow']);
        Route::delete('/unFollow', [UserController::class, 'unFollow']);
    });
})->middleware([RequestApiAuthCheckMiddleware::class]);
