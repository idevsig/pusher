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

class Mattermost extends \Pusher\Channel
{
    private string $uri_template = '%s/api/v4/posts';

    protected string $default_url = '';
    protected string $method = Pusher::METHOD_JSON;

    private string $channel_id = ''; // 频道 ID

    public function __construct(array $config = [])
    {
        parent::configureDefaults($config);
    }

    public function setChannelID(string $channel_id): self
    {
        $this->channel_id = $channel_id;

        return $this;
    }

    public function getChannelID(): string
    {
        return $this->channel_id;
    }

    public function doCheck(Message $message): self
    {
        $this->params = $message->getParams();

        if ($this->custom_url !== '') {
            $this->request_url = $this->config['url'] . $this->custom_url;
            $this->custom_url = '';
        } else {
            $this->request_url = sprintf($this->uri_template, $this->config['url']);
        }

        $this->options['headers'] = [
            'Authorization' => sprintf('Bearer %s', $this->token),
        ];
        $this->params['channel_id'] = $this->channel_id;

        return $this;
    }

    public function doAfter(): self
    {
        $this->status = true;

        return $this;
    }
}
