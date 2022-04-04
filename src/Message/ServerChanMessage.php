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

class ServerChanMessage extends Message
{
    private string $title = ''; // 通知标题
    private string $desp = '';  // 通知内容

    public function __construct(string $title = '', string $desp = '')
    {
        $this->title = $title;
        $this->desp = $desp;
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

    public function setDesp(string $desp): self
    {
        $this->desp = $desp;

        return $this;
    }

    public function getDesp(): string
    {
        return $this->desp;
    }

    public function generateParams(): self
    {
        $this->params = [
            'title' => $this->title,
            'desp' => $this->desp,
        ];

        return $this;
    }
}
