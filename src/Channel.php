<?php declare(strict_types=1);

/*
 * This file is part of Pusher.
 *
 * (c) Jetsung Chan <skiy@jetsung.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pusher;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Channel implements ChannelInterface
{
    public Client $client;

    protected array  $config = [];
    protected string $base_url = '';
    protected string $token = '';
    
    protected string $content = ''; // 请求结果正文
    protected bool $status = false; // 请求状态

    public function configureDefaults(array $config): void
    {
        $default = [
            'base_url' => $this->base_url,
        ];

        if (isset($config['token'])) {
            $this->setToken($config['token']);
            unset($config['token']);
        }

        if (isset($config['base_url']) && filter_var($config['base_url'], FILTER_VALIDATE_URL) === false) {
            unset($config['base_url']);
        }

        $this->config = $default + $config;
        $this->setBaseURL($this->config['base_url']);
    }

    public function setBaseURL(string $base_url): self
    {
        if (filter_var($base_url, FILTER_VALIDATE_URL) === false) {
            return $this;
        }

        $this->config['base_url'] = rtrim($base_url, '/');
        return $this;
    }

    public function getBaseURL(): string
    {
        return $this->config['base_url'];
    }

    public function generateURI(): string
    {
        return $this->config['base_url'];
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function request(Message $message): ResponseInterface
    {
        return $this->client->request('GET');
    }

    public function requestContent(Message $message): string
    {
        $this->content = $this->request($message)->getBody()->getContents();
        return $this->content;
    }

    public function requestArray(Message $message): array
    {
        return Utils::strToArray($this->requestContent($message));
    }

}
