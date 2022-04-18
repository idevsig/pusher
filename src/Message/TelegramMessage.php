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

class TelegramMessage extends Message
{
    private string $text = '';     // 通知内容
    private bool   $sound = false; // 通知声音

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

    public function setSound(bool $enable): self
    {
        $this->sound = $enable;

        return $this;
    }

    public function getSound(): bool
    {
        return $this->sound;
    }

    public function generateParams(): self
    {
        $this->params = [
            'text' => $this->text,
            'disable_notification' => !$this->sound,
        ];

        return $this;
    }
}
