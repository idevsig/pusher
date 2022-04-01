<?php declare(strict_types=1);

/*
 * This file is part of Pusher.
 *
 * (c) Jetsung Chan <skiy@jetsung.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pusher\Tests\Channels;

use PHPUnit\Framework\TestCase;
use Pusher\Channel\QQBot;
use Pusher\Message\QQBotMessage;

class QQBotTest extends TestCase
{
    private string $token = 'IHoXWmSmGtiTDasWtm8vqX9LARJY0k5r';
    private string $appID = '102002742';
    private string $channelID = '4616538';

    const PASS = false;

    public function skipTest(string $func, bool $skip = false): void
    {

        if (self::PASS || $skip) {
            $this->markTestSkipped("skip ${func}");
        }
    }

    // 延时
    public function timeSleep(int $time = 5): void
    {
        sleep($time);
    }

    public function testContentCases(): void
    {
        $this->skipTest(__METHOD__, false);
        $this->timeSleep(10);

        $channel = new QQBot();
        $channel->setAppID($this->appID)
            ->setChannelID($this->channelID)
            ->Sandbox(true)
            ->setToken($this->token);
        // var_dump($channel);

        $message = new QQBotMessage('文本类型 content 的消息发送');

        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }

    public function testImageCases(): void
    {
        $this->skipTest(__METHOD__, false);
        $this->timeSleep(10);

        $channel = new QQBot();
        $channel->setAppID($this->appID)
            ->setChannelID($this->channelID)
            ->Sandbox(true)
            ->setToken($this->token);
        // var_dump($channel);

        $message = new QQBotMessage();
        $message->setImage('https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png');

        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }

    // 不允许发送源文本 
    // {"code":50056,"message":"raw markdown not allowed"}
    public function testMarkdownCases(): void
    {
        $this->skipTest(__METHOD__, true);
        $this->timeSleep(10);

        $channel = new QQBot();
        $channel->setAppID($this->appID)
            ->setChannelID($this->channelID)
            ->Sandbox(true)
            ->setToken($this->token);
        // var_dump($channel);

//         $markdown = "![screenshot](https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png) 
// ### 乔布斯 20 年前想打造的苹果咖啡厅 
// Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划";
        $markdown = '## 这是一个 Markdown 内容';        

        $message = new QQBotMessage();
        $message->setMarkdown([ 'content' => $markdown]);

        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }

    public function testEmbedCases(): void
    {
        $this->skipTest(__METHOD__, false);
        $this->timeSleep(10);

        $channel = new QQBot();
        $channel->setAppID($this->appID)
            ->setChannelID($this->channelID)
            ->Sandbox(true)
            ->setToken($this->token);
        // var_dump($channel);

        $embed = [
            'title' => '这个是标题：Embed',
            'prompt' => '这个是弹窗内容。',
            'thumbnail' => [
                'url' => 'https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png',
            ],
            'fields' => [
                [ 'name' => '当前等级：黄金' ],
                [ 'name' => '之前等级：白银' ],
                [ 'name' => '😁继续努力' ],
            ],
        ];
 
        $message = new QQBotMessage();
        $message->setEmbed($embed);

        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }


    public function testArkCases(): void
    {
        $this->skipTest(__METHOD__, false);
        $this->timeSleep(10);

        $channel = new QQBot();
        $channel->setAppID($this->appID)
            ->setChannelID($this->channelID)
            ->Sandbox(true)
            ->setToken($this->token);
        // var_dump($channel);

        $ark = [
            'template_id' => 23,
            'kv' => [
                [
                    'key' => '#DESC#',
                    'value' => 'descaaaaaa',
                ],
                [
                    'key' => '#PROMPT#',
                    'value' => 'promptaaaa',
                ],
                [
                    'key' => '#LIST#',
                    'obj' => [
                    [
                        'obj_kv' => [
                        [
                            'key' => 'desc',
                            'value' => '此消息标题：ark 类型',
                        ],
                        ],
                    ],
                    [
                        'obj_kv' => 
                        [
                        [
                            'key' => 'desc',
                            'value' => '当前状态"体验中"点击下列动作直接扭转状态到：',
                        ],
                        ],
                    ],
                    // [
                    //     'obj_kv' => [
                    //     [
                    //         'key' => 'desc',
                    //         'value' => '已评审',
                    //     ],
                    //     [
                    //         'key' => 'link',
                    //         'value' => 'https://qun.qq.com',
                    //     ],
                    //     ],
                    // ],
                    // [
                    //     'obj_kv' => [
                    //     [
                    //         'key' => 'desc',
                    //         'value' => '已排期',
                    //     ],
                    //     [
                    //         'key' => 'link',
                    //         'value' => 'https://qun.qq.com',
                    //     ],
                    //     ],
                    // ],
                    // [
                    //     'obj_kv' => [
                    //     [
                    //         'key' => 'desc',
                    //         'value' => '开发中',
                    //     ],
                    //     [
                    //         'key' => 'link',
                    //         'value' => 'https://qun.qq.com',
                    //     ],
                    //     ],
                    // ],
                    // [
                    //     'obj_kv' => [
                    //     [
                    //         'key' => 'desc',
                    //         'value' => '增量测试中',
                    //     ],
                    //     [
                    //         'key' => 'link',
                    //         'value' => 'https://qun.qq.com',
                    //     ],
                    //     ],
                    // ],
                        [
                            'obj_kv' => [
                            [
                                'key' => 'desc',
                                'value' => '请关注',
                            ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
 
        $message = new QQBotMessage();
        $message->setArk($ark);

        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }

    // 获取用户频道列表 GET /users/@me/guilds
    public function testGuildsCases(): string
    {
        $this->skipTest(__METHOD__, true);

        $channel = new QQBot();
        $channel->setAppID($this->appID)
            ->setToken($this->token);
        // var_dump($channel);

        $resp = $channel->send('/users/@me/guilds', [], 'get');

        $this->assertEquals(200, $resp->getStatusCode());

        $jsonData = json_decode($resp->getBody()->getContents(), true);
        if (count($jsonData) > 0) {
            return $jsonData[0]['id'];
        }
        return '';
    }

    /**
     * 获取子频道列表 GET /guilds/{guild_id}/channels
     * @depends testGuildsCases
     */
    public function testChannelsCases(string $guildID): void
    {
        $this->skipTest(__METHOD__, true);

        $this->assertNotEmpty($guildID);

        $channel = new QQBot();
        $channel->setAppID($this->appID)
            ->setToken($this->token);
        // var_dump($channel);

        $resp = $channel->send(sprintf('/guilds/%s/channels', $guildID), [], 'get');
        $jsonData = json_decode($resp->getBody()->getContents(), true);

        // print_r($jsonData);
        $this->assertEquals(200, $resp->getStatusCode());

        if (count($jsonData) > 0) {
            echo "\n" . implode(',', array_column($jsonData, 'id'));
        }
    }

}
