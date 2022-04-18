<?php declare(strict_types=1);

/*
 * This file is part of Pusher.
 *
 * (c) Jetsung Chan <jetsungchan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pusher\Channel;

use Exception;
use Pusher\Message;
use Pusher\Pusher;
use Pusher\Utils;

class Telegram extends \Pusher\Channel
{
    private string $uri_template = '%s/bot%s/sendMessage';

    protected string $default_url = 'https://api.telegram.org';
    protected string $method = Pusher::METHOD_JSON;

    private string $chat_id = '';  // 频道的用户名或唯一标识符

    public function __construct(array $config = [])
    {
        parent::configureDefaults($config);
    }

    public function setChatID(string $id): self
    {
        $this->chat_id = $id;

        return $this;
    }

    public function getChatID(): string
    {
        return $this->chat_id;
    }

    public function doCheck(Message $message): self
    {
        $this->params = $message->getParams();

        if ($this->custom_url !== '') {
            $this->request_url = sprintf('%s/bot%s%s', $this->config['url'], $this->token, $this->custom_url);
            $this->custom_url = '';
        } else {
            $this->request_url = sprintf($this->uri_template, $this->config['url'], $this->token);
        }
        $this->params['chat_id'] = $this->chat_id;

        return $this;
    }

    public function doAfter(): self
    {
        try {
            $resp = Utils::strToArray($this->content);
            $this->status = $resp['ok'];
        } catch (Exception $e) {
            $this->error_message = $e->getMessage();
            $this->status = false;
        }

        return $this;
    }
}
