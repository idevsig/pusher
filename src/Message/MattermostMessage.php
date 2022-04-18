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

class MattermostMessage extends Message
{
    private string $message = ''; // 消息内容

    public function __construct(string $message = '')
    {
        $this->message = $message;
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

    public function generateParams(): self
    {
        $this->params = [
            'message' => $this->message,
        ];

        return $this;
    }
}
