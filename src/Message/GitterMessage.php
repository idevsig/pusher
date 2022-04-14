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

class GitterMessage extends Message
{
    private string $text = '';  // 通知内容

    private bool $status = false; // 状态更新 (Me)

    public function __construct(string $text = '')
    {
        $this->text = $text;
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

    public function setStatus(bool $enable): self
    {
        $this->status = $enable;

        return $this;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function generateParams(): self
    {
        $this->params = [
            'text' => $this->text,
            'status' => $this->status,
        ];

        return $this;
    }
}
