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

class FeishuMessage extends Message
{
    public const TYPE_TEXT = 'text';
    public const TYPE_POST = 'post';
    public const TYPE_IMAGE = 'image';
    public const TYPE_SHARE_CHAT = 'share_chat';
    public const TYPE_INTERACTIVE = 'interactive';

    private string $msgType = ''; // 消息类型 text,post,image,share_chat,interactive
    private string $title = '';     // 消息标题

    // text 文本类型
    private string $text = '';

    // post 富文本类型
    private array $contents = []; // 段落. 一个富文本可分多个段落

    // image 图片类型
    private string $imageKey = ''; // 图片的唯一标识

    // share_chat "分享群名片"类型
    private string $shareChatID = ''; // 群名片 ID

    // interactive "消息卡片"类型
    private array $interactiveElements = []; // 用于定义卡片正文内容
    private array $interactiveI18nElements = []; // 为卡片的正文部分定义多语言内容
    private array $interactiveConfig = []; // 卡片属性
    private array $interactiveHeader = []; // 卡片标题

    public function __construct(
        string $msg_type = '',
        string $title = '',
    ) {
        $this->msgType = $this->filter_message_type($msg_type);
        $this->title = $title;
    }

    public function setMsgType(string $type): self
    {
        $this->msgType = $this->filter_message_type($type);

        return $this;
    }

    public function getMsgType(): string
    {
        return $this->msgType;
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

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setContents(array $contents): self
    {
        $this->contents = $contents;

        return $this;
    }

    public function getContents(): array
    {
        return $this->contents;
    }

    public function addContent(array $content): self
    {
        $this->contents[] = $content;

        return $this;
    }

    public function setImageKey(string $key): self
    {
        $this->imageKey = $key;

        return $this;
    }

    public function getImageKey(): string
    {
        return $this->imageKey;
    }

    public function setShareChatID(string $shareChatID): self
    {
        $this->shareChatID = $shareChatID;

        return $this;
    }

    public function getShareChatID(): string
    {
        return $this->shareChatID;
    }

    public function setInteractiveElements(array $elements): self
    {
        $this->interactiveElements = $elements;

        return $this;
    }

    public function getInteractiveElements(): array
    {
        return $this->interactiveElements;
    }

    public function setInteractiveI18nElements(array $elements): self
    {
        $this->interactiveI18nElements = $elements;

        return $this;
    }

    public function getInteractiveI18nElements(): array
    {
        return $this->interactiveI18nElements;
    }

    public function setInteractiveHeader(array $header): self
    {
        $this->interactiveHeader = $header;

        return $this;
    }

    public function getInteractiveHeader(): array
    {
        return $this->interactiveHeader;
    }

    public function setInteractiveConfig(array $config): self
    {
        $this->interactiveConfig = $config;

        return $this;
    }

    public function getInteractiveConfig(): array
    {
        return $this->interactiveConfig;
    }

    public function generateParams(): self
    {
        $this->params = [
            'msg_type' => $this->msgType,
        ];

        $params = [];

        switch ($this->msgType) {
            case self::TYPE_POST:
                $params = [
                    'content' => [
                        'post' => [
                            'zh_cn' => [
                                'title' => $this->title,
                                'content' => $this->contents,
                            ],
                        ],
                    ],
                ];
                break;

            case self::TYPE_IMAGE:
                $params = [
                    'content' => [
                        'image_key' => $this->imageKey,
                    ],
                ];
                break;

            case self::TYPE_SHARE_CHAT:
                $params = [
                    'content' => [
                        'share_chat_id' => $this->shareChatID,
                    ],
                ];
                break;

            case self::TYPE_INTERACTIVE:
                $params = [
                    'card' => [
                        'config' => $this->interactiveConfig,
                        'header' => $this->interactiveHeader,
                        // 'elements' => $this->interactiveElements,
                        // 'i18n_elements' => $this->interactiveI18nElements,
                    ],
                ];
                empty($this->interactiveElements) || $params['card']['elements'] = $this->interactiveElements;
                empty($this->interactiveI18nElements) || $params['card']['i18n_elements'] = $this->interactiveI18nElements;

                break;

            case self::TYPE_TEXT:
            default:
                $params = [
                    'content' => [
                        'text' => $this->text,
                    ],
                ];
        }

        $this->params += $params;
        // echo json_encode($this->params);
        return $this;
    }

    public function filter_message_type(string $type): string
    {
        return in_array($type, [
            self::TYPE_TEXT,
            self::TYPE_POST,
            self::TYPE_IMAGE,
            self::TYPE_SHARE_CHAT,
            self::TYPE_INTERACTIVE,
            ]) ? $type : self::TYPE_TEXT;
    }
}
