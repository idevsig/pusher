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

class QQBotMessage extends Message
{
    private string $content = '';  // 通知内容

    private array  $embed = [];    // embed 消息
    private array  $ark = [];      // ark 消息
    private string $image = '';    // 图片 url 地址，平台会转存该图片，用于下发图片消息
    private array $markdown = [];  // markdown 消息对象

    private array $messageReference = []; // 引用消息
    private string $msgID = ''; // 要回复的消息 ID

    public function __construct(string $content = '')
    {
        $this->content = $content;
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

    public function setEmbed(array $embed): self
    {
        $this->embed = $embed;

        return $this;
    }

    public function getEmbed(): array
    {
        return $this->embed;
    }

    public function setArk(array $ark): self
    {
        $this->ark = $ark;

        return $this;
    }

    public function getArk(): array
    {
        return $this->ark;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setMarkdown(array $markdown): self
    {
        $this->markdown = $markdown;

        return $this;
    }

    public function getMarkdown(): array
    {
        return $this->markdown;
    }

    public function setMessageReference(array $message): self
    {
        $this->messageReference = $message;

        return $this;
    }

    public function getMessageReference(): array
    {
        return $this->messageReference;
    }

    public function setMsgID(string $msgID): self
    {
        $this->msgID = $msgID;

        return $this;
    }

    public function getMsgID(): string
    {
        return $this->msgID;
    }

    public function generateParams(): self
    {
        $this->params = [
            'msg_id' => $this->msgID,
            'content' => $this->content,

        ];

        if (!empty($this->markdown)) {
            $this->params['markdown'] = $this->markdown;
        } elseif (!empty($this->image)) {
            $this->params['image'] = $this->image;
        } elseif (!empty($this->embed)) {
            $this->params['embed'] = $this->embed;
        } elseif (!empty($this->ark)) {
            $this->params['ark'] = $this->ark;
        } elseif (!empty($this->messageReference)) {
            $this->params['message_reference'] = $this->messageReference;
        }

        return $this;
    }
}
