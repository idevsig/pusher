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

class NowPushMessage extends Message
{
    private string $message_type = ''; // 消息类型
    private string $note = '';  // 消息内容
    private string $device_type = ''; // 消息来自设备类型
    private string $url = ''; // 链接

    public function __construct(string $message_type = '')
    {
        $this->message_type = $this->filter_message_type($message_type);
    }

    public function setMessageType(string $type): self
    {
        $this->message_type = $this->filter_message_type($type);

        return $this;
    }

    public function getMessageType(): string
    {
        return $this->message_type;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getNote(): string
    {
        return $this->note;
    }

    public function setDeviceType(string $type): self
    {
        $this->device_type = $type;

        return $this;
    }

    public function getDeviceType(): string
    {
        return $this->device_type;
    }

    public function setURL(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getURL(): string
    {
        return $this->url;
    }

    public function generateParams(): self
    {
        $this->params = [
            'message_type' => $this->message_type,
            'note' => $this->note,
            'device_type' => $this->device_type,
            'url' => $this->url,
        ];

        return $this;
    }

    private function filter_message_type(string $type): string
    {
        $type = strtolower($type);

        return in_array($type, [ 'nowpush_note', 'nowpush_img', 'nowpush_link' ]) ? $type : 'nowpush_note';
    }
}
