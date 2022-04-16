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

class Zulip extends \Pusher\Channel
{
    private string $uri_template = '%s/api/v1/messages';

    protected string $default_url = '';
    protected string $method = Pusher::METHOD_POST;

    private string $email = '';
    private string $api_key = '';

    public function __construct(array $config = [])
    {
        parent::configureDefaults($config);
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setApiKey(string $key): self
    {
        $this->api_key = $key;

        return $this;
    }

    public function getApiKey(): string
    {
        return $this->api_key;
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

        if ($this->token !== '') {
            $this->options['headers'] = [
                'Authorization' => sprintf('Basic %s', $this->token),
            ];
        } elseif ($this->email !== '' && $this->api_key !== '') {
            $this->options['auth'] = [ $this->email, $this->api_key ];
        }

        return $this;
    }

    public function doAfter(): self
    {
        try {
            $resp = Utils::strToArray($this->content);
            $this->status = $resp['result'] === 'success';
        } catch (Exception $e) {
            $this->error_message = $e->getMessage();
            $this->status = false;
        }

        return $this;
    }
}
