<?php

namespace app\service\impl;

use app\exception\ApiBusinessException;
use app\model\SysUserModel;
use app\service\AuthService;
use DI\Attribute\Inject;
use support\Request;
use Throwable;
use Tinywan\Jwt\JwtToken;

class AuthServiceImpl implements AuthService
{
    #[Inject]
    protected SysUserModel $sysUserModel;

    /**
     * @throws Throwable
     */
    public function login(Request $request): array
    {
        $data = $request->only(['username', 'password']);

        $sysUser = $this->sysUserModel->newQuery()->where('username', $data['username'])->first();
        throw_unless($sysUser, ApiBusinessException::class, '您的账号信息不存在,请检查您的账号信息或前往注册');

        throw_if($sysUser->status != 1, ApiBusinessException::class, '您的账号处于不能登录的状态,请联系管理员处理');

        $verify = password_verify($data['password'], $sysUser->password);

//        $password = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);

        throw_unless($verify, ApiBusinessException::class, '您输入的密码信息与账号不匹配,请检查您的信息是否正确');

        $sysUser->last_login = date('Y-m-d H:i:s', time());
        $sysUser->save();

        return JwtToken::generateToken(array_merge($sysUser->toArray(), ['client' => JwtToken::TOKEN_CLIENT_MOBILE]));
    }

    public function refreshToken(): array
    {
        return JwtToken::refreshToken();
    }

    public function logout(): void
    {
        JwtToken::clear();
    }


}