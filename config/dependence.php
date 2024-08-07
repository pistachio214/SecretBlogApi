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

use Psr\Container\ContainerInterface;

use app\service\AuthService;
use app\service\impl\AuthServiceImpl;

use app\service\AppMainService;
use app\service\impl\AppMainServiceImpl;

use app\service\PostService;
use app\service\impl\PostServiceImpl;

use app\service\UserService;
use app\service\impl\UserServiceImpl;


return [
    AuthService::class => function (ContainerInterface $container) {
        return $container->get(AuthServiceImpl::class);
    },
    AppMainService::class => function (ContainerInterface $container) {
        return $container->get(AppMainServiceImpl::class);
    },
    PostService::class => function (ContainerInterface $container) {
        return $container->get(PostServiceImpl::class);
    },
    UserService::class => function (ContainerInterface $container) {
        return $container->get(UserServiceImpl::class);
    },
];