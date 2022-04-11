<?php declare(strict_types=1);

/*
 * This file is part of Pusher.
 *
 * (c) Jetsung Chan <skiy@jetsung.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pusher\Message;

use Pusher\Message;

class PushoverMessage extends Message
{
    private string $message = ''; // 通知内容
    private string $title = '';   // 通知标题

    private string $device = '';  // 设备名称

    private bool $html = false; // 是否支持 HTML
    private string $url = ''; // 链接

    public function __construct(string $message = '', string $title = '')
    {
        $this->message = $message;
        $this->title = $title;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setHtml(bool $enable): self
    {
        $this->html = $enable;

        return $this;
    }

    public function getHtml(): bool
    {
        return $this->html;
    }

    public function setURL(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getURL(): string
    {
        return $this->url;
    }

    public function setDevice(string $device): self
    {
        $this->device = $device;

        return $this;
    }

    public function getDevice(): string
    {
        return $this->device;
    }

    public function generateParams(): self
    {
        $this->params = [
            'title' => $this->title,
            'message' => $this->message,
            'device' => $this->device,
            'html' => $this->html ? 1 : 0,
            'url' => $this->url,
        ];

        return $this;
    }
}
