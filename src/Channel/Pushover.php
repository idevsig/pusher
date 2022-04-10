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

class Pushover extends \Pusher\Channel
{
    private string $uri_template = '%s/1/messages.json';

    protected string $default_url = 'https://api.pushover.net';
    protected string $method = Pusher::METHOD_JSON;

    private string $user = ''; // UserKey, GroupKey

    public function __construct(array $config = [])
    {
        parent::configureDefaults($config);
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function doCheck(Message $message): self
    {
        $this->params = $message->getParams();
        $this->request_url = sprintf($this->uri_template, $this->config['url']);
        $this->params['token'] = $this->token;
        $this->params['user'] = $this->user;

        return $this;
    }

    public function doAfter(): self
    {
        try {
            $resp = Utils::strToArray($this->content);
            $this->status = $resp['status'] === 1;
        } catch (Exception $e) {
            $this->error_message = $e->getMessage();
            $this->status = false;
        }

        return $this;
    }
}
