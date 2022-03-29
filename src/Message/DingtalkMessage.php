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

class DingtalkMessage extends Message
{
    private string $msgtype = 'text'; // 消息类型 text,link,markdown,actionCard,feedCard
    private string $content = '';     // 通知内容
    private string $title   = '';     // 消息标题


    // text,markdown 类型
    private array $atMobiles = [];    // 被@人的手机号
    private array $atUserIds = [];    // 被@人的用户userid
    private bool  $isAtAll = false;   // 是否@所有人

    // link 类型
    private string $messageUrl = '';  // M, 点击消息跳转的URL
    private string $picUrl     = '';  // 图片URL

    // ActionCard 类型
    private string $btnOrientation = '0'; // 排列方向 0：按钮竖直排列,1：按钮横向排列

    ///（整体跳转）
    private string $singleTitle = '';    // M, 单个按钮的标题
    private string $singleURL   = '';    // M, 点击消息跳转的URL

    ///（独立跳转）
    private array $btns = [];  // M, 按钮列表 [{'title', 'actionURL'}, {'title', 'actionURL'}]

    // FeedCard 类型
    private array $links = []; // M, 链接列表 [{'title', 'messageURL', 'picURL'}, {'title', 'messageURL', 'picURL'}]

    public function __construct(
        string $msgtype = 'text', 
        string $content = '', 
        string $title   = '',
        )
    {
        $this->msgtype = $msgtype;
        $this->content = $content;
        $this->title   = $title;
    }

    public function setAtMobiles(array $mobile): self
    {
        $this->atMobiles = $mobile;
        return $this;
    }

    public function getAtMobiles(): array
    {
        return $this->atMobiles;
    }

    public function setAtUserIds(array $users): self
    {
        $this->atUserIds = $users;
        return $this;
    }

    public function getAtUserIds(): array
    {
        return $this->atUserIds;
    }

    public function setIsAll(bool $all): self
    {
        $this->isAtAll = $all;
        return $this;
    }

    public function getIsAll(): bool
    {
        return $this->isAtAll;
    }

    public function setMessageUrl(string $messageUrl): self
    {
        $this->messageUrl = $messageUrl;
        return $this;
    }

    public function getMessageUrl(): string
    {
        return $this->messageUrl;
    }

    public function setPicUrl(string $picUrl): self
    {
        $this->picUrl = $picUrl;
        return $this;
    }

    public function getPicUrl(): string
    {
        return $this->picUrl;
    }

    public function setBtnOrientation(string $btnOrientation): self
    {
        $this->btnOrientation = $btnOrientation;
        return $this;
    }

    public function getBtnOrientation(): string
    {
        return $this->btnOrientation;
    }

    public function setSingleTitle(string $singleTitle): self
    {
        $this->singleTitle = $singleTitle;
        return $this;
    }

    public function getSingleTitle(): string
    {
        return $this->singleTitle;
    }

    public function setSingleURL(string $singleURL): self
    {
        $this->singleURL = $singleURL;
        return $this;
    }

    public function getSingleURL(): string 
    {
        return $this->singleURL;
    }

    public function setBtns(array $btns): self
    {
        $this->btns = $btns;
        return $this;
    }

    public function getBtns(): array
    {
        return $this->btns;
    }

    public function addBtn(string $title, string $actionURL): self
    {
        $this->btns[] = [
            'title' => $title,
            'actionURL' => $actionURL,
        ];
        return $this;
    }

    public function setLinks(array $links): self
    {
        $this->links = $links;
        return $this;
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    public function addLink(string $title, string $messageURL, string $picURL): self
    {
        $this->links[] = [
            'title' => $title, 
            'messageURL' => $messageURL, 
            'picURL' => $picURL,
        ];
        return $this;
    }

    public function generateParams(): self
    {
        $this->params = [
            'msgtype' => $this->msgtype,
        ];

        $params = [];

        switch($this->msgtype) {
            case 'link':
                $params = [
                    'link' => [
                        'title'  => $this->title,
                        'text'   => $this->content,
                        'picUrl' => $this->picUrl,
                        'messageUrl' => $this->messageUrl,
                    ],
                ];
                break;

            case 'markdown':
                $params = [
                    'markdown' => [
                        'title' => $this->title,
                        'text'  => $this->content,
                    ],
                    'at' => [
                        'atMobiles' => $this->atMobiles,
                        'atUserIds' => $this->atUserIds,
                        'isAtAll'   => $this->isAtAll,
                    ],
                ];
                break;

            case 'actionCard':
                $params = [
                    'actionCard' => [
                        'title' => $this->title,
                        'text'  => $this->content,
                        'btnOrientation' => $this->btnOrientation,
                    ],
                ];

                if (count($this->btns) > 0) {
                    $params['actionCard']['btns'] = $this->btns;
                }
                else
                {
                    $params['actionCard']['singleTitle'] = $this->singleTitle;
                    $params['actionCard']['singleURL'] = $this->singleURL;
                }
                break;
            
            case 'feedCard':
                $params = [
                    'feedCard' => [
                        'links' => $this->links,
                    ],
                ];
                break;

            case 'text':
            default: 
                $params = [
                    'text' => [
                        'content' => $this->content,
                    ],
                    'at' => [
                        'atMobiles' => $this->atMobiles,
                        'atUserIds' => $this->atUserIds,
                        'isAtAll'   => $this->isAtAll,
                    ],
                ];
        }

        $this->params += $params;
        return $this;
    }
}
