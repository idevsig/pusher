<?php declare(strict_types=1);

/*
 * This file is part of Pusher.
 *
 * (c) Jetsung Chan <jetsungchan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pusher;

use Exception;
use GuzzleHttp\Psr7\Response;

class Channel implements ChannelInterface
{
    protected array  $config = [];    // 配置

    protected string $default_url = ''; // 默认 URL
    protected string $request_url = ''; // 请求 URL (已拼接的最终 URL)
    protected string $custom_url = '';  // 定制请求 URL
    protected string $token = ''; // Token

    protected string $method = Pusher::METHOD_GET;    // 请求方式：GET,POST,JSON (POST)
    protected array  $params = [];       // 请求数据
    protected array  $options = [];       // 选项，比如 proxy,headers,cookies

    protected Response $response;       // 返回数据
    protected string $content = '';     // 请求结果正文

    protected bool   $status = false;  // 请求状态
    protected string $error_message = ''; // 错误信息

    public function configureDefaults(array $config): void
    {
        $default = [
            'url' => $this->default_url,
        ];

        // 存在 token 参数，设置 token 值
        if (isset($config['token'])) {
            $this->setToken($config['token']);
            unset($config['token']);
        }

        // 存在 URL 参数，但判断不正确
        if (isset($config['url']) && filter_var($config['url'], FILTER_VALIDATE_URL) === false) {
            unset($config['url']);
        }

        $this->config = $default + $config;
        $this->setURL($this->config['url']);
    }

    public function setURL(string $base_url): self
    {
        if (filter_var($base_url, FILTER_VALIDATE_URL) === false) {
            return $this;
        }

        $this->config['url'] = rtrim($base_url, '/');

        return $this;
    }

    public function getURL(): string
    {
        return $this->config['url'];
    }

    public function setReqURL(string $url): self
    {
        $this->custom_url = $url;

        return $this;
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

    public function setMethod(string $method = 'GET'): self
    {
        $method = strtoupper($method);
        if (!in_array($method, [ Pusher::METHOD_GET, Pusher::METHOD_POST, Pusher::METHOD_JSON])) {
            $method = Pusher::METHOD_GET;
        }
        $this->method = $method;

        return $this;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getContents(): string
    {
        return $this->content;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getErrMessage(): string
    {
        return $this->error_message;
    }

    // 需要定制（数据请求前需要拼接请求 URL、Token、请求头等等）
    public function doCheck(Message $message): self
    {
        $this->params = $message->getParams();

        return $this;
    }

    // 需要定制（数据需要解析，并且判断请求是否成功）
    public function doAfter(): self
    {
        return $this;
    }

    public function send(string $method = Pusher::METHOD_GET, string $uri = '', array $data = [], array $options = []): Response
    {
        $method = strtoupper($method);
        if ($method === Pusher::METHOD_JSON) {
            $method = Pusher::METHOD_POST;
            $options['json'] = $data;
        } elseif ($method === Pusher::METHOD_POST) {
            $options['form_params'] = $data;
        } else {
            $method = Pusher::METHOD_GET;
        }

        // var_dump($method, $uri, $options);
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request($method, $uri, $options);
        } catch (Exception $e) {
            $status_code = $e->getCode();
            if ($status_code === 0) {
                $status_code = 408; // 请求超时 （比如 proxy 错误）
            }
            $this->error_message = $e->getMessage();
            $response = new Response($status_code);
        }

        return $response;
    }

    public function request(Message $message): string
    {
        $this->doCheck($message);
        $this->response = $this->send($this->method, $this->request_url, $this->params, $this->options);
        // var_dump($this->request_url, $this->params);
        $status_code = $this->response->getStatusCode();
        if ($status_code >= 200 &&
                $status_code <= 299) {
            $this->content = $this->response->getBody()->getContents();
            $this->doAfter();
        }

        return $this->content;
    }

    public function requestArray(Message $message): array
    {
        return Utils::strToArray($this->request($message));
    }
}
