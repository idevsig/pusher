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

class PushBackMessage extends Message
{
    private string $body = '';  // 通知内容
    private string $title = ''; // 通知标题
    private string $id = '';    // id
    private string $action1 = '';
    private string $action2 = '';
    private string $reply = '';

    public function __construct(string $body = '', string $title = '')
    {
        $this->body = $body;
        $this->title = $title;
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

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setID(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getID(): string
    {
        return $this->id;
    }

    public function setAction1(string $action): self
    {
        $this->action1 = $action;

        return $this;
    }

    public function getAction1(): string
    {
        return $this->action1;
    }

    public function setAction2(string $action): self
    {
        $this->action2 = $action;

        return $this;
    }

    public function getAction2(): string
    {
        return $this->action2;
    }

    public function setReply(string $reply): self
    {
        $this->reply = $reply;

        return $this;
    }

    public function getReply(): string
    {
        return $this->reply;
    }

    public function generateParams(): self
    {
        $this->params = [
            'title' => $this->title,
            'body' => $this->body,
            'id' => $this->id,
            'action1' => $this->action1,
            'action2' => $this->action2,
            'reply' => $this->reply,
        ];

        return $this;
    }
}
