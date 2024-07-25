<?php

namespace plugin\admin\app\controller;

use support\Log;
use support\Request;
use support\Response;
use plugin\admin\app\model\AppBanner;
use plugin\admin\app\controller\Crud;
use support\exception\BusinessException;

/**
 * 轮播设置 
 */
class AppBannerController extends Crud
{
    
    /**
     * @var AppBanner
     */
    protected $model = null;

    /**
     * 构造函数
     * @return void
     */
    public function __construct()
    {
        $this->model = new AppBanner;
    }
    
    /**
     * 浏览
     * @return Response
     */
    public function index(): Response
    {
        return view('app-banner/index');
    }

    /**
     * 插入
     * @param Request $request
     * @return Response
     * @throws BusinessException
     */
    public function insert(Request $request): Response
    {
        if ($request->method() === 'POST') {
            return parent::snowflakeInsert($request);
        }
        return view('app-banner/insert');
    }

    /**
     * 更新
     * @param Request $request
     * @return Response
     * @throws BusinessException
    */
    public function update(Request $request): Response
    {
        if ($request->method() === 'POST') {
            Log::info(json_encode($request->post()));
            return parent::update($request);
        }
        return view('app-banner/update');
    }

}
