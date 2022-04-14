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

use Exception;
use Pusher\Message;
use Pusher\Pusher;
use Pusher\Utils;
use WebSocket\Client;

class QQBot extends \Pusher\Channel
{
    private string $uri_template = '%s/channels/%s/messages';

    protected string $default_url = 'https://api.sgroup.qq.com';
    protected string $method = Pusher::METHOD_JSON;

    private Client $wsClient;

    private string $appID = '';     // APP ID
    private string $channelID = ''; // 子频道 ID
    private string $wss_url = 'wss://api.sgroup.qq.com/websocket';

    // 沙盒模式
    private bool $sandbox = false;
    private string $req_sandbox_url = 'https://sandbox.api.sgroup.qq.com';
    private string $wss_sandbox_url = 'wss://sandbox.api.sgroup.qq.com/websocket';

    public function __construct(array $config = [])
    {
        parent::configureDefaults($config);
    }

    public function Sandbox(bool $sandbox = false): self
    {
        $this->sandbox = $sandbox;
        $url = $this->sandbox ? $this->req_sandbox_url : $this->default_url;
        $this->setURL($url);

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

    public function setReqURL(string $url): self
    {
        $this->custom_url = $url;

        return $this;
    }

    public function doCheck(Message $message): self
    {
        if ($this->custom_url !== '') {
            $this->request_url = sprintf('%s%s', $this->config['url'], $this->custom_url);
            $this->custom_url = '';
        } else {
            $this->request_url = sprintf($this->uri_template, $this->config['url'], $this->channelID);
        }

        // 非 GET 请求，需要连接 WS
        if ($this->method !== 'GET') {
            $wssURL = $this->sandbox ? $this->wss_sandbox_url : $this->wss_url;
            $this->wsClient = new \WebSocket\Client($wssURL);
            // $client->text("Hello WebSocket.org!");
            $this->wsClient->text(json_encode([
                'op' => 2,
                'd' => [
                    'token' => sprintf('Bot %s.%s', $this->appID, $this->token),
                    'intents' => 0 | 1 << 9,
                ],
            ]));
            // echo $client->receive();

            $this->params = $message->getParams();
        }

        $this->options = [
            'headers' => [
                'Authorization' => sprintf('Bot %s.%s', $this->appID, $this->token),
            ],
        ];

        return $this;
    }

    public function doAfter(): self
    {
        if (isset($this->wsClient) && $this->wsClient->isConnected()) {
            $this->wsClient->close();
        }

        try {
            $resp = Utils::strToArray($this->content);

            if ($this->method !== Pusher::METHOD_GET) {
                if (in_array($resp['code'], [ 200, 304023 ])) {
                    $this->status = true;
                } else {
                    new Exception($resp['message'], 401);
                }
            } else {
                $this->status = true;
            }
        } catch (Exception $e) {
            $this->error_message = $e->getMessage();
            $this->status = false;
        }

        return $this;
    }
}
