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

class Feishu extends \Pusher\Channel
{
    private string $secret = '';
    private string $uri_template = '%s/open-apis/bot/v2/hook/%s';

    protected string $default_url = 'https://open.feishu.cn';
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
        if ($this->secret !== '') {
            $timestamp = time();
            $this->params['timestamp'] = $timestamp;
            $this->params['sign'] = Utils::generateSign($this->secret, $timestamp);
        }

        $this->request_url = sprintf($this->uri_template, $this->config['url'], $this->token);

        return $this;
    }

    public function doAfter(): self
    {
        try {
            $resp = Utils::strToArray($this->content);
            $this->status = $resp['StatusCode'] === 0;
        } catch (Exception $e) {
            $this->error_message = $e->getMessage();
            $this->status = false;
        }

        return $this;
    }
}
