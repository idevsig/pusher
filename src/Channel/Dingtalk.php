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
use Pusher\Utils;

class Dingtalk extends \Pusher\Channel
{
    private string $secret = '';
    private string $uri_template = '%s/robot/send?access_token=%s';

    protected string $default_url = 'https://oapi.dingtalk.com';
    protected string $method = 'JSON';

    public function __construct(array $config = [])
    {
        parent::configureDefaults($config);
    }

    public function setSecret(string $secret): self
    {
        $this->secret = $secret;

        return $this;
    }

    public function doCheck(Message $message): self
    {
        $this->params = $message->getParams();

        $uri = '';
        if ($this->secret !== '') {
            $timestamp = time() * 1000;
            $sign = Utils::generateSign($this->secret, $timestamp);
            $uri = sprintf('&timestamp=%d&sign=%s', $timestamp, $sign);
        }

        $this->request_url = sprintf($this->uri_template, $this->config['url'], $this->token) . $uri;

        return $this;
    }

    public function doAfter(): self
    {
        try {
            $resp = Utils::strToArray($this->content);
            $this->status = $resp['errcode'] === 0;
        } catch (Exception $e) {
            $this->error_message = $e->getMessage();
            $this->status = false;
        }

        return $this;
    }
}
