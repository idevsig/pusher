<?php declare(strict_types=1);

/*
 * This file is part of Pusher.
 *
 * (c) Jetsung Chan <jetsungchan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pusher\Message;

use Pusher\Message;

class PushPlusMessage extends Message
{
    private string $content = ''; // 通知内容
    private string $title = ''; // 通知标题

    private string $template = ''; // 发送消息模板, html,json,cloudMonitor 阿里云监控报警定制模板 (该平台不支持)
    private string $topic = ''; // 群组编码

    public function __construct(string $content = '', string $title = '')
    {
        $this->content = $content;
        $this->title = $title;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
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

    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function setTopic(string $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    public function getTopic(): string
    {
        return $this->topic;
    }

    public function generateParams(): self
    {
        $this->params = [
            'title' => $this->title,
            'content' => $this->content,
            'template' => $this->template,
            'topic' => $this->topic,
        ];

        return $this;
    }
}
