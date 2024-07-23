<?php

namespace app\api\controller;

use app\service\MailerService;

use support\Request;
use support\Response;

use DI\Attribute\Inject;


class AppBannerController
{
    /**
     * @var MailerService
     */
    #[Inject]
    protected MailerService $mailerService;

    public function index(Request $request): Response
    {
        $this->mailerService->mail('email', 'content');

        return json("hello,world");
    }

}
