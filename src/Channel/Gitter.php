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

use Pusher\Message;
use Pusher\Pusher;

class Gitter extends \Pusher\Channel
{
    private string $uri_template = '%s/v1/rooms/%s/chatMessages';

    protected string $default_url = 'https://api.gitter.im';
    protected string $method = Pusher::METHOD_JSON;

    private string $room_id = '';  // 房间 ID

    public function __construct(array $config = [])
    {
        parent::configureDefaults($config);
    }

    public function setRoomID(string $id): self
    {
        $this->room_id = $id;

        return $this;
    }

    public function getRoomID(): string
    {
        return $this->room_id;
    }

    public function setReqURL(string $url): self
    {
        $this->custom_url = $url;

        return $this;
    }

    public function doCheck(Message $message): self
    {
        $this->params = $message->getParams();

        if ($this->custom_url !== '') {
            $this->request_url = $this->config['url'] . $this->custom_url;
            $this->custom_url = '';
        } else {
            $this->request_url = sprintf($this->uri_template, $this->config['url'], $this->room_id);
        }
        $this->options['headers'] = [
            'Authorization' => sprintf('Bearer %s', $this->token),
        ];

        return $this;
    }

    public function doAfter(): self
    {
        $this->status = true;

        return $this;
    }
}
