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

class WxPusherMessage extends Message
{
    private string $content = ''; // 通知内容

    private string $summary = ''; // 消息摘要 不传默认截取content前面的内容
    private int $contentType = 1; // 内容类型 1表示文字  2表示html(只发送body标签内部的数据即可，不包括body标签) 3表示markdown
    private array $topicIds = []; // 发送目标的topicId，是一个数组！！！，也就是群发，使用uids单发的时候， 可以不传。
    private array $uids = [];     // 发送目标的UID，是一个数组。注意uids和topicIds可以同时填写，也可以只填写一个。
    private string $url = '';     // 原文链接，可选参数 

    public function __construct(string $content = '')
    {
        $this->content  = $content;
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

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;
        return $this;
    } 

    public function getSummary(): string
    {
        return $this->summary;
    }

    public function setContentType(int $contentType): self
    {
        $this->contentType = $contentType;
        return $this;
    }

    public function getContentType(): int
    {
        return $this->contentType;
    }

    public function setTopicIds(array $topicIds): self
    {
        $this->topicIds = $topicIds;
        return $this;
    }

    public function getTopicIds(): array
    {
        return $this->topicIds;
    }

    public function setUids(array $uids): self
    {
        $this->uids = $uids;
        return $this;
    }

    public function getUids(): array
    {
        return $this->uids;
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
            'content' => $this->content,
            'summary' => $this->summary,
            'contentType' => $this->contentType,
            'topicIds' => $this->topicIds,
            'uids' => $this->uids,
            'url' => $this->url,
        ];
        return $this;
    }
}
