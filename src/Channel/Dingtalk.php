<?php declare(strict_types=1);

/*
 * This file is part of Pusher.
 *
 * (c) Jetsung Chan <skiy@jetsung.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pusher\Channel;

use Psr\Http\Message\ResponseInterface;
use Pusher\Message;

class Dingtalk extends \Pusher\Channel
{
    private string $secret;

    protected string $base_url = 'https://oapi.dingtalk.com';
    protected string $uri_template = '%s/robot/send?access_token=%s&timestamp=%d&sign=%s';

    public function __construct(array $config = [])
    {
        $this->client = new \GuzzleHttp\Client();
        $this->secret = $config['secret'];

        parent::configureDefaults($config);
    }

    public function request(Message $message): ResponseInterface
    {
        $timestamp = time() * 1000;
        $stringToSign = sprintf("%s\n%s", $timestamp, $this->secret);
        $signData = hash_hmac('sha256', $stringToSign, $this->secret, true);
        $sign = urlencode(base64_encode($signData));

        $request_uri = sprintf($this->uri_template, $this->config['base_url'], $this->getToken(), $timestamp, $sign);
        $postData = $message->getParams();

        return $this->client->request('POST', $request_uri, [ 'json' => $postData ]);
    }
}
