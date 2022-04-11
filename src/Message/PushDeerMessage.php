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

class PushDeerMessage extends Message
{
    public const TYPE_TEXT = 'text';
    public const TYPE_MARKDOWN = 'markdown';
    public const TYPE_IMAGE = 'image';

    private string $type = ''; // 通知类型 text,markdown,image
    private string $desp = ''; // 通知内容
    private string $text = ''; // 通知标题

    public function __construct(string $type = '', string $desp = '', string $text = '')
    {
        $this->type = $this->filter_message_type($type);
        $this->desp = $desp;
        $this->text = $text;
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

    public function setDesp(string $desp): self
    {
        $this->desp = $desp;

        return $this;
    }

    public function getDesp(): string
    {
        return $this->desp;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function generateParams(): self
    {
        $this->params = [
            'text' => $this->text,
            'desp' => $this->desp,
            'type' => $this->type,
        ];

        return $this;
    }

    private function filter_message_type(string $type): string
    {
        $type = strtolower($type);

        return in_array($type, [ self::TYPE_TEXT, self::TYPE_MARKDOWN, self::TYPE_IMAGE ]) ? $type : self::TYPE_TEXT;
    }
}
