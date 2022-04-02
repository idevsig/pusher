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

class Xizhi extends \Pusher\Channel
{
    protected string $base_url = 'https://xizhi.qqoq.net';
    protected string $uri_template = '%s/%s.%s';

    private string $type = 'send'; // 推送类型：单点.send，频道.channel

    public function __construct(array $config = [])
    {
        parent::configureDefaults($config);
        $this->client = new \GuzzleHttp\Client();
    }

    public function setType(string $type = 'send'): self
    {
        $this->type = ($type === 'channel') ? 'channel' : 'send';
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStatus(): bool
    {
        $resp = Utils::strToArray($this->content);
        $this->status = $resp['code'] === 200;
        $this->showResp();
        return $this->status;
    }

    public function request(Message $message): ResponseInterface
    {
        $request_uri = sprintf($this->uri_template, $this->config['base_url'], $this->token, $this->type);
        $postData = $message->getParams();

        return $this->client->request('POST', $request_uri, [ 'form_params' => $postData]);
    }

}
