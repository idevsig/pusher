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

class MailerMessage extends Message
{
    private string $subject = ''; // 主题
    private string $body    = ''; // 内容
    private string $altBody = ''; // 非 HTML 邮件客户端的纯文本正文

    public function __construct(string $subject = '', string $body = '', string $altBody = '')
    {
        $this->subject = $subject;
        $this->body  = $body;
        $this->altBody = $altBody;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
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

    public function setAltBody(string $altBody): self
    {
        $this->altBody = $altBody;
        return $this;
    }

    public function getAltBody(): string
    {
        return $this->altBody;
    }

    public function generateParams(): self
    {
        $this->params = [
            'subject' => $this->subject,
            'body' => $this->body,
            'altBody' => $this->altBody,
        ];
        return $this;
    }
}
