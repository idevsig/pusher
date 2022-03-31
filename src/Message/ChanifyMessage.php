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

use PhpParser\Node\Expr\Cast\Object_;
use Pusher\Message;

class ChanifyMessage extends Message
{
    private string $title   = '';  // 通知标题
    private string $text    = '';  // 通知内容
    private string $copy    = '';  // 复制文本
    private int    $autocopy = 1;  // 自动复制
    private int    $sound    = 1;  // 启用声音
    private int    $priority = 10; // 优先级
    // active: 点亮屏幕并可能播放声音。
    // passive: 不点亮屏幕或播放声音。
    // time-sensitive: 点亮屏幕并可能播放声音； 可能会在“请勿打扰”期间展示。
    private string $interruptionLevel = 'active'; // 通知时间的中断级别
    private array $actions  = []; // 动作列表
    private array $timeline = []; // Timeline 对象

    // 发送链接
    private string $link = '';

    // 发送图片
    private string $image = '';

    public function __construct(string $title = '', string $text = '')
    {
        $this->title = $title;
        $this->text  = $text;
    }

    public function setCopy(string $copy): self
    {
        $this->copy = $copy;
        return $this;
    }

    public function getCopy(): string
    {
        return $this->copy;
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

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setInterruptionLevel(string $interruptionLevel): self
    {
        $this->interruptionLevel = $interruptionLevel;
        return $this;
    }

    public function getInterruptionLevel(): string
    {
        return $this->interruptionLevel;
    }

    public function setActions(array $actions): self
    {  
        $this->actions = $actions;
        return $this;
    }

    public function getActions(): array
    {
        return $this->actions;
    }

    public function addAction(string $action): self
    {
        $this->actions[] = $action;
        return $this;
    }

    public function setTimeline(array $timeline): self
    {
        $this->timeline = $timeline;
        return $this;
    }

    public function getTimeline(): array
    {
        return $this->timeline;
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

    public function generateParams(): self
    {
        if ($this->link !== '') 
        {
            $this->params = [
                'sound' => $this->sound,
                'priority' => $this->priority,
                'link' => $this->link,
            ];
        }
        else
        {
            $this->params = [
                'title' => $this->title,
                'text' => $this->text,
                'copy' => $this->copy,
                'autocopy' => $this->autocopy,
                'sound' => $this->sound,
                'priority' => $this->priority,
                'interruption-level' => $this->interruptionLevel,
                'actions' => $this->actions,
                'timeline' => $this->timeline,
            ];

            if (! empty($this->timeline)) {
                unset($this->params['actions']);
            } else {
                unset($this->params['timeline']);
            }
        }
        return $this;
    }
}
