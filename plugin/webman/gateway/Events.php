<?php

namespace plugin\webman\gateway;

use GatewayWorker\Lib\Gateway;
use support\Log;

class Events
{
    public static function onWorkerStart($worker): void
    {

    }

    public static function onConnect($client_id): void
    {
        Log::info("Connect Success, client_id: " . $client_id);
    }

    public static function onWebSocketConnect($client_id, $data): void
    {
        Log::info("WebSocket Connect Success, client_id: " . $client_id . "; data:" . json_encode($data));
    }

    public static function onMessage($client_id, $message): void
    {
        $data = json_decode($message, true);

        if ($data['code'] == 100) {
            // 1. 链接成功之后,客户端主动发送信息进行绑定
            Gateway::bindUid($client_id, $data['uid']);

            Gateway::sendToClient($client_id, "receive message 客户端与client_id绑定成功!");
        }

        if ($data['code'] == 200) {
            $msg = $data['message'];
            $target_uid = $data['target_uid'];

            Gateway::sendToUid($target_uid, $msg);
        }

    }

    public static function onClose($client_id): void
    {
        $uid = Gateway::getUidByClientId($client_id);

        // 退出的时候,需要进行 uid与client解绑
        Gateway::unbindUid($client_id, $uid);

        Log::info("Connect Close, client_id: " . $client_id);
    }

}
