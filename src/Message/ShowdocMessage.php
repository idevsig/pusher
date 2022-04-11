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

class ShowdocMessage extends Message
{
    private string $content = ''; // 通知内容
    private string $title = ''; // 通知标题

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

    public function generateParams(): self
    {
        $this->params = [
            'title' => $this->title,
            'content' => $this->content,
        ];

        return $this;
    }
}
