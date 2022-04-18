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

class TechulusMessage extends Message
{
    private string $body = '';  // 通知内容
    private string $title = ''; // 通知标题

    private string $link = '';  // 通知链接
    private string $image = ''; // 通知图片

    public function __construct(string $body = '', string $title = '')
    {
        $this->body = $body;
        $this->title = $title;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
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

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
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

    public function generateParams(): self
    {
        $this->params = [
            'title' => $this->title,
            'body' => $this->body,
            'link' => $this->link,
            'image' => $this->image,
        ];

        return $this;
    }
}
