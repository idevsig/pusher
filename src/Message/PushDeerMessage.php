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
    private string $text; // 通知标题
    private string $desp; // 通知内容
    private string $type; // 通知类型 text,markdown,image

    public function __construct(string $text = '', string $desp = '', string $type = '')
    {
        $this->text = $text;
        $this->desp = $desp;
        $this->type = $type;
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

    public function setDesp(string $desp): self
    {
        $this->desp = $desp;
        return $this;
    }

    public function getDesp(): string
    {
        return $this->desp;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
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
}
