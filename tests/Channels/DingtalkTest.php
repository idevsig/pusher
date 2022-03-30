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
use Pusher\Channel\Dingtalk;
use Pusher\Message\DingtalkMessage;

class DingtalkTest extends TestCase
{
    private string $token = '18f7e22470ca8307b6bc382413dcc1b13a2a3603c4a264460c698b36eec3dfba';
    private string $secret = 'SEC5f0dd6237d0e3d253bb9db726822cc4dd79186bba482c0e3ad40ac0d3f19a50f';

    ## 钉钉限制每分钟只能发 20 条信息，故跳过单元测试
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

    public function additionProviderTextMarkdown(): array
    {
        $at = [
            'atMobiles' => [],
            'atUserIds' => [ 'skiychan' ],
            'isAtAll'   => true,
        ];

        $at2 = array_merge($at, [ 'isAtAll' => false ]);

        return [
            ['text', 'TEXT 消息内容', '', $at], 
            ['text', 'TEXT 消息内容 no at all', '', $at2], 
            ['markdown', "#### 杭州天气 @150XXXXXXXX \n > 9度，西北风1级，空气良89，相对温度73%\n > ![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png)\n > ###### 10点20分发布 [天气](https://www.dingtalk.com) \n", '首屏会话透出的展示内容', $at], 
        ];
    }

    public function additionProviderActionCard(): array
    {

        $content = "![screenshot](https://gw.alicdn.com/tfs/TB1ut3xxbsrBKNjSZFpXXcXhFXa-846-786.png) 
### 乔布斯 20 年前想打造的苹果咖啡厅 
Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划";
        $title = '乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身';

        $btns = [
            [ 'title' => '百度网址', 'actionURL' => 'https://www.baidu.com' ],
            [ 'title' => '头条网址', 'actionURL' => 'https://www.toutiao.com' ],
            [ 'title' => '腾讯网址', 'actionURL' => 'https://www.tencent.com' ],
        ];

        return [
            [ $content, $title, '0', '阅读全文', 'https://www.dingtalk.com/' ], 
            [ $content, $title, '1', '点击阅读全文', 'https://www.dingtalk.com/' ], 
            [ $content, $title, '0', '', '', $btns ], 
            [ $content, $title, '1', '', '', $btns ], 
        ];
    }

    /**
     * @dataProvider additionProviderTextMarkdown
     *
     * @return void
     */
    public function testTextMarkdownCases(string $msgtype, string $content, string $title = '', array $at = []): void
    {
        $this->skipTest(__METHOD__);

        $channel = new Dingtalk();
        $channel->setSecret($this->secret)
            ->setToken($this->token);
        // var_dump($channel);

        $message = new DingtalkMessage($msgtype, $content, $title);
        $message->setAtMobiles($at['atMobiles'])
            ->setAtUserIds($at['atUserIds'])
            ->setIsAll($at['isAtAll']);

        $resp = $channel->requestJson($message);
        // var_dump($resp);

        $this->assertEquals(0, $resp['errcode']);

        $this->timeSleep(10);
    }

    public function testLinkCase(): void
    {
        $this->skipTest(__METHOD__);

        $channel = new Dingtalk();
        $channel->setSecret($this->secret)
            ->setToken($this->token);
        // var_dump($channel);

        $message = new DingtalkMessage('link', '这个即将发布的新版本，创始人xx称它为红树林。而在此之前，每当面临重大升级，产品经理们都会取一个应景的代号，这一次，为什么是红树林', '时代的火车向前开');
        $message->setPicUrl('https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png')
            ->setMessageUrl('https://www.aliyun.com');

        $resp = $channel->requestJson($message);
        // var_dump($resp);

        $this->assertEquals(0, $resp['errcode']);       

        $this->timeSleep(10);
    }

    public function testFeedCardCase(): void
    {
        $this->skipTest(__METHOD__);

        $channel = new Dingtalk();
        $channel->setSecret($this->secret)
            ->setToken($this->token);
        // var_dump($channel);

        $links = [
            [
                'title'      => '百度',
                'messageURL' => 'https://www.baidu.com',
                'picURL'     => 'https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png',
            ],
            [
                'title'      => '360搜索',
                'messageURL' => 'https://so.com',
                'picURL'     => 'https://p.ssl.qhimg.com/t012cdb572f41b93733.png',
            ],
        ];

        $message = new DingtalkMessage('feedCard');
        $message->setLinks($links)
            ->addLink('跳转到百度官网', 'https://baidu.com', 'https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png');

        $resp = $channel->requestJson($message);
        // var_dump($resp);

        $this->assertEquals(0, $resp['errcode']);    

        $this->timeSleep(10);
    }

    /**
     * @dataProvider additionProviderActionCard
     *
     * @return void
     */
    public function testActionCardCases(string $content, 
        string $title, 
        string $btnOrientation,
        string $singleTitle,
        string $singleURL,
        array $btns = [],
    ): void
    {
        $this->skipTest(__METHOD__);

        $channel = new Dingtalk();
        $channel->setSecret($this->secret)
            ->setToken($this->token);
        // var_dump($channel);

        $message = new DingtalkMessage('actionCard', $content, $title);
        $message->setBtnOrientation($btnOrientation);

        if (count($btns) > 0) {
            $message->setBtns($btns)
                ->addBtn('项目地址', 'https://github.com/jetsung/pusher');
        } 
        else
        {
            $message->setSingleTitle($singleTitle)
                ->setSingleURL($singleURL);
        }
        

        $resp = $channel->requestJson($message);
        // var_dump($resp);

        $this->assertEquals(0, $resp['errcode']);   

        $this->timeSleep(10);
    }

}
