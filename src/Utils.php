<?php declare(strict_types=1);

/*
 * This file is part of Pusher.
 *
 * (c) Jetsung Chan <jetsungchan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pusher;

class Utils
{
    /**
     * 钉钉 签名
     */
    public static function generateSign(string $secret, int $timestamp): string
    {
        $stringToSign = sprintf("%s\n%s", $timestamp, $secret);
        $signData = hash_hmac('sha256', $stringToSign, $secret, true);

        return urlencode(base64_encode($signData));
    }

    /**
     * 飞书 Lark 签名
     */
    public static function generateSign2(string $secret, int $timestamp): string
    {
        $stringToSign = sprintf("%s\n%s", $timestamp, $secret);
        $signData = hash_hmac('sha256', '', $stringToSign, true);

        return base64_encode($signData);
    }

    public static function strToArray(string $message): array
    {
        return json_decode($message, true);
    }

    public static function xmlToArray(string $message): array
    {
        $xmlObj = simplexml_load_string($message);

        return json_decode(json_encode($xmlObj), true);
    }
}
