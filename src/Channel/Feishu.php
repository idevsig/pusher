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

class Feishu extends \Pusher\Channel
{
    private string $secret = '';

    protected string $base_url = 'https://open.feishu.cn';
    protected string $uri_template = '%s/open-apis/bot/v2/hook/%s';

    public function __construct(array $config = [])
    {
        parent::configureDefaults($config);
        $this->client = new \GuzzleHttp\Client();
    }

    public function setSecret(string $secret): self
    {
        $this->secret = $secret;

        return $this;
    }

    public function getStatus(): bool
    {
        $resp = Utils::strToArray($this->content);
        $this->status = $resp['StatusCode'] === 0;
        $this->showResp();

        return $this->status;
    }

    public function request(Message $message): ResponseInterface
    {
        $request_uri = sprintf($this->uri_template, $this->config['base_url'], $this->token);
        $postData = $message->getParams();

        if ($this->secret !== '') {
            $timestamp = time();
            $sign = Utils::generateSign($this->secret, $timestamp);
            $postData['timestamp'] = $timestamp;
            $postData['sign'] = $sign;
        }

        return $this->client->request('POST', $request_uri, [ 'json' => $postData ]);
    }
}
