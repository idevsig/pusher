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

class BarkMessage extends Message
{
    private string $title = '';  // 通知标题
    private string $body = '';   // 通知内容
    private int    $badge = 1;   // 图标旁边显示数字
    private string $copy = '';   // 复制文本
    private string $sound = '';  // 通知提示音
    private string $icon = '';   // 图标的 URL
    private string $group = '';  // 通知组
    private string $url = '';    // 跳转 URL

    public function __construct(string $body = '', string $title = '')
    {
        $this->body = $body;
        $this->title = $title;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
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

    public function setBadge(int $badge): self
    {
        $this->badge = $badge;

        return $this;
    }

    public function getBadge(): int
    {
        return $this->badge;
    }

    public function setCopy(string $copy): self
    {
        $this->copy = $copy;

        return $this;
    }

    public function getCopy(): string
    {
        return $this->copy;
    }

    public function setSound(string $sound): self
    {
        $this->sound = $sound;

        return $this;
    }

    public function getSound(): string
    {
        return $this->sound;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function setGroup(string $group): self
    {
        $this->group = $group;

        return $this;
    }

    public function getGroup(): string
    {
        return $this->group;
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

    public function generateParams(): self
    {
        $this->params = [
            'body' => $this->body,
            'title' => $this->title,
            'badge' => $this->badge,
            'sound' => $this->sound,
            'icon' => $this->icon,
            'group' => $this->group,
            'url' => $this->url,
        ];

        return $this;
    }
}
