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

class WeCom extends \Pusher\Channel
{
    private string $uri_template = '%s/cgi-bin/webhook/send?key=%s';

    protected string $default_url = 'https://qyapi.weixin.qq.com';
    protected string $method = Pusher::METHOD_JSON;

    public function __construct(array $config = [])
    {
        parent::configureDefaults($config);
    }

    public function doCheck(Message $message): self
    {
        $this->params = $message->getParams();
        $this->request_url = sprintf($this->uri_template, $this->config['url'], $this->token);

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
