<?php

use Webman\Route;

use app\middleware\RequestApiAuthCheckMiddleware;

use app\api\controller\TestController;

use app\api\controller\PostController;
use app\api\controller\UserController;
use app\api\controller\MainDynamicController;
use app\api\controller\MainDiscoveryController;


Route::get('/api/test', [TestController::class, 'test'])->middleware([RequestApiAuthCheckMiddleware::class]);

Route::group('/api', function () {

    /**
     * 星球 - 首页
     */
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

        /**
         * 自拍
         */
        Route::group('/selfie', function () {
            Route::get("/post", [MainDynamicController::class, 'selfieList']);
        });

        // TODO 视频
        Route::group('/video', function () {
        });
    });

    /**
     * 热度
     */
    Route::group('/main-discovery', function () {

        /**
         * 话题模块
         */
        Route::group('/topic', function () {
            Route::get("/hot-top-tags", [MainDiscoveryController::class, 'tagTopList']);
            Route::get("/hot-tags", [MainDiscoveryController::class, 'tagList']);

            Route::get("/post/{id:\d+}", [MainDiscoveryController::class, 'postListByTopic']);
        });

        // TODO 附近模块
        Route::group("/nearby", function () {
        });

        /**
         * 约伴模块
         */
        Route::group("/accompany", function () {
            Route::get('/post', [MainDiscoveryController::class, 'postListByAccompany']);
            Route::put('/join/{id:\d+}', [MainDiscoveryController::class, 'joinAccompany']);
            Route::get('/users/{id:\d+}', [MainDiscoveryController::class, 'userListByAccompany']);
        });

        /**
         * 看法模块
         */
        Route::group("/top-view", function () {
            Route::get("/post", [MainDiscoveryController::class, 'postListByTopView']);
        });
    });

    //TODO 对话
    Route::group("/message", function () {
    });

    /**
     * 用户
     */
    Route::group("/user", function () {
        Route::get("/mine", [UserController::class, 'mine']);
        Route::get("/profile", [UserController::class, 'profile']);
        Route::get("/dynamic", [UserController::class, 'dynamic']);

        Route::get('/mine/{id:\d+}', [UserController::class, 'mineByUserId']);
        Route::get('/profile/{id:\d+}', [UserController::class, 'profileByUserId']);
        Route::get('/dynamic/{id:\d+}', [UserController::class, 'dynamicByUserId']);

        Route::post("/edit", [UserController::class, 'edit']);
    });

    Route::group('/post', function () {
        Route::post('', [PostController::class, 'create']);
        Route::post('/selfie', [PostController::class, 'createSelfie']);
        Route::post('/accompany', [PostController::class, 'createAccompany']);
        Route::post('/top-view', [PostController::class, 'createTopView']);

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
