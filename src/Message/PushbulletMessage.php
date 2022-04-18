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

class PushbulletMessage extends Message
{
    public const TYPE_NOTE = 'note';
    public const TYPE_FILE = 'file';
    public const TYPE_LINK = 'link';

    private string $type = ''; // 类型: note,file,link
    private string $body = ''; // 通知内容
    private string $title = ''; // 通知标题

    // link 类型
    private string $url = '';

    // file 类型
    private string $file_name = '';
    private string $file_type = '';
    private string $file_url = '';

    private string $email = '';       //接收者
    private string $device_iden = ''; // 接收者设备 ID
    private string $client_iden = ''; // 客户端 ID
    private string $channel_tag = ''; // 通道

    public function __construct(string $type = '', string $body = '', string $title = '')
    {
        $this->type = $this->filter_message_type($type);
        $this->body = $body;
        $this->title = $title;
    }

    public function setType(string $type): self
    {
        $this->type = $this->filter_message_type($type);

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
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

    public function setURL(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getURL(): string
    {
        return $this->url;
    }

    public function setFileName(string $name): self
    {
        $this->file_name = $name;

        return $this;
    }

    public function getFileName(): string
    {
        return $this->file_name;
    }

    public function setFileType(string $type): self
    {
        $this->file_type = $type;

        return $this;
    }

    public function getFileType(): string
    {
        return $this->file_type;
    }

    public function setFileURL(string $url): self
    {
        $this->file_url = $url;

        return $this;
    }

    public function getFileURL(): string
    {
        return $this->file_url;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setDeviceIden(string $iden): self
    {
        $this->device_iden = $iden;

        return $this;
    }

    public function getDeviceIden(): string
    {
        return $this->device_iden;
    }

    public function setClientIden(string $iden): self
    {
        $this->client_iden = $iden;

        return $this;
    }

    public function getClientIden(): string
    {
        return $this->client_iden;
    }

    public function setChannelTag(string $tag): self
    {
        $this->channel_tag = $tag;

        return $this;
    }

    public function getChannelTag(): string
    {
        return $this->channel_tag;
    }

    public function generateParams(): self
    {
        $this->params = [
            'type' => $this->type,
            'title' => $this->title,
            'body' => $this->body,
            'url' => $this->url,
            'file_name' => $this->file_name,
            'file_type' => $this->file_type,
            'file_url' => $this->file_url,
        ];

        if ($this->email !== '') {
            $this->params['email'] = $this->email;
        }

        if ($this->device_iden !== '') {
            $this->params['device_iden'] = $this->device_iden;
        }

        if ($this->client_iden !== '') {
            $this->params['client_iden'] = $this->client_iden;
        }

        if ($this->channel_tag !== '') {
            $this->params['channel_tag'] = $this->channel_tag;
        }

        return $this;
    }

    private function filter_message_type(string $type): string
    {
        $type = strtolower($type);

        return in_array($type, [ self::TYPE_NOTE, self::TYPE_LINK, self::TYPE_FILE ]) ? $type : self::TYPE_NOTE;
    }
}
