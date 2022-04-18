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

class PushsaferMessage extends Message
{
    private string $message = '';
    private string $title = '';

    private int $sound = 0; // 声音
    private int $vibration = 1; // 振动
    private int $icon = 1;
    private string $icon_color = '';
    private string $device = 'a';
    private string $url = '';
    private string $url_title = '';
    private string $picture = '';

    public function __construct(string $message = '', string $title = '')
    {
        $this->message = $message;
        $this->title = $title;
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

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setSound(int $sound): self
    {
        $this->sound = $sound;

        return $this;
    }

    public function getSound(): int
    {
        return $this->sound;
    }

    public function setVibration(int $vibration): self
    {
        $this->vibration = $vibration;

        return $this;
    }

    public function getVibration(): int
    {
        return $this->vibration;
    }

    public function setIcon(int $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): int
    {
        return $this->icon;
    }

    public function setIconColor(string $color): self
    {
        $this->icon_color = $color;

        return $this;
    }

    public function getIconColor(): string
    {
        return $this->icon_color;
    }

    public function setDevice(string $device): self
    {
        $this->device = $device;

        return $this;
    }

    public function getDevice(): string
    {
        return $this->device;
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

    public function setUrlTitle(string $title): self
    {
        $this->url_title = $title;

        return $this;
    }

    public function getUrlTitle(): string
    {
        return $this->url_title;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function generateParams(): self
    {
        $this->params = [
            't' => $this->title,
            'm' => $this->message,
            's' => $this->sound,
            'v' => $this->vibration,
            'i' => $this->icon,
            'c' => $this->icon_color,
            'd' => $this->device,
            'u' => $this->url,
            'ut' => $this->url_title,
            'p' => $this->picture,
        ];

        return $this;
    }
}
