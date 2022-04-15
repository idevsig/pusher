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

class ZulipMessage extends Message
{
    public const TYPE_PRIVATE = 'private'; // 私人
    public const TYPE_STREAM = 'stream';  // 流

    private string $type = '';     // 通知类型 ['private', 'stream']
    private string|int $to = ''; // 对于流消息，流的名称或整数ID。对于私人消息，包含包含整数用户ID的列表或包含字符串电子邮件地址的列表。
    private string $content = '';  // 消息内容
    private string $topic = '';    // 主题

    public function __construct(string $type = '', string $content = '')
    {
        $this->type = $this->filter_message_type($type);
        $this->content = $content;
    }

    public function setType(string $type): self
    {
        $this->type = $this->filter_message_type($type);

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setTo(string|int $to): self
    {
        $this->to = $to;

        return $this;
    }

    public function getTo(): string|int
    {
        return $this->to;
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
            'type' => $this->type,
            'to' => $this->to,
            'content' => $this->content,
        ];

        if ($this->type === self::TYPE_STREAM) {
            $this->params['topic'] = $this->topic;
        }

        return $this;
    }

    private function filter_message_type(string $type): string
    {
        $type = strtolower($type);

        return in_array($type, [ self::TYPE_PRIVATE, self::TYPE_STREAM ]) ? $type : self::TYPE_PRIVATE;
    }
}
