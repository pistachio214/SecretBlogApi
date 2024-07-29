<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Webman\Route;

use app\api\controller\TestController;

use app\api\controller\PostController;
use app\api\controller\MainDynamicController;

Route::group('/api', function () {

    Route::get('/test', [TestController::class, 'test']);

    Route::group('/main-dynamic', function () {
        Route::get("/banner", [MainDynamicController::class, 'bannerList']);
        Route::get("/post", [MainDynamicController::class, 'postList']);
    });

    Route::group('/post', function () {
        Route::get('/{id:\d+}', [PostController::class, 'detail']);
        Route::get('/reply/{id}', [PostController::class, 'replyMessage']);
    });


});
