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
use Pusher\Utils;

class QQBot extends \Pusher\Channel
{
    protected string $uri_template = '%s/channels/%s/messages';

    protected string $base_url = 'https://api.sgroup.qq.com';
    protected string $sandbox_base_url = 'https://sandbox.api.sgroup.qq.com'; // 沙箱

    private string $wss_url = 'wss://api.sgroup.qq.com/websocket';
    private string $wss_shanbox_url = 'wss://sandbox.api.sgroup.qq.com/websocket';

    private string $appID = '';     // APP ID
    private string $channelID = ''; // 子频道 ID

    private bool $sandbox = false; // 沙箱模式

    public function __construct(array $config = [])
    {
        parent::configureDefaults($config);
        $this->client = new \GuzzleHttp\Client();
    }

    public function getStatus(): bool
    {
        $resp = Utils::strToArray($this->content);
        $this->status = in_array($resp['code'], [ 200, 304023 ]) ?? false;
        $this->showResp();
        return $this->status;
    }

    public function Sandbox(bool $sandbox = false): self
    {
        $this->sandbox = $sandbox;
        if ($sandbox) {
            $this->config['base_url'] = $this->sandbox_base_url;
        } else {
            $this->config['base_url'] = $this->base_url;
        }
        return $this;
    }

    public function setAppID(string $appID): self
    {
        $this->appID = $appID;
        return $this;
    }

    public function setChannelID(string $channelID): self
    {
        $this->channelID = $channelID;
        return $this;
    }

    public function request(Message $message): ResponseInterface
    {
        $request_uri = sprintf($this->uri_template, $this->config['base_url'], $this->channelID);
        $postData = $message->getParams();

        $wssURL = $this->wss_url;
        if ($this->sandbox) {
            $wssURL = $this->wss_shanbox_url;
        }
        $client = new \WebSocket\Client($wssURL);
        // $client->text("Hello WebSocket.org!");
        $client->text(json_encode([
            'op' => 2,
            'd' => [
                'token' => sprintf('Bot %s.%s', $this->appID, $this->token),
                'intents' => 0 | 1 << 9,
            ],
        ]));
        // echo $client->receive();
        $resp = $this->req($request_uri, $postData);
        $client->close();
        return $resp;
    }

    // 定制 POST 请求（比如获取频道列表，子频道列表等）
    public function send(string $uri, array $postData, string $method = 'POST'): ResponseInterface
    {
        return $this->req(sprintf('%s%s', $this->config['base_url'], $uri), $postData, $method);
    }

    private function req(string $url, array $postData, string $method = 'POST'): ResponseInterface
    {
        $options = [ 
            'headers' => [
                'Authorization' => sprintf('Bot %s.%s', $this->appID, $this->token),
            ],
        ];
        if (strtoupper($method) === 'POST') {
            $options['json'] = $postData;
        }

        return $this->client->request($method, $url, $options);
    }

}
