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

class Webhook extends \Pusher\Channel
{
    private string $method = 'GET'; // 请求方式：GET,POST,POST_JSON
    private array $options = [];    // 选项，比如 proxy,headers,cookies

    public function __construct(array $config = [])
    {
        parent::configureDefaults($config);
        $this->client = new \GuzzleHttp\Client();
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function request(Message $message): ResponseInterface
    {
        $postData = $message->getParams();

        $resp = $this->send($this->method, $this->config['base_url'], $postData, $this->options);

        return $resp;
    }
}
