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
use Pusher\Channel\Feishu;
use Pusher\Message\FeishuMessage;

class FeishuTest extends TestCase
{
    private string $token = '';
    private string $secret = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('FeishuToken');
        $secret = getenv('FeishuSecret');
        if ($token && $secret) {
            $this->token = $token;
            $this->secret = $secret;
        } else {
            self::$PASS = true;
        }
    }

    public function skipTest(string $func, bool $skip = false): void
    {
        if (self::$PASS || $skip) {
            $this->markTestSkipped("skip ${func}");
        }
    }

    // 延时
    public function timeSleep(int $time = 5): void
    {
        sleep($time);
    }

    public function additionProviderText(): array
    {
        return [
            [ 'text', '文本类型内容推送' ],
            // [ 'text', '<at user_id="ou_xxx">用户名</at> 文本类型内容推送给指定用户' ], // 需"自建应用"
            [ 'text', '<at user_id="all">所有人</at> 文本类型内容推送给全部' ],
        ];
    }

    /**
     * @dataProvider additionProviderText
     *
     * @param string $title
     * @param string $text
     * @return void
     */
    public function testTextCases(string $title, string $text): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Feishu();
        $channel->setSecret($this->secret)
            ->setToken($this->token);

        $message = new FeishuMessage($title);
        $message->setText($text);

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }

    public function testPostCases(): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Feishu();
        $channel->setSecret($this->secret)
            ->setToken($this->token);

        $first_content = [
            [
                'tag' => 'text',
                'text' => '第一行',
            ],
            [
                'tag' => 'a',
                'href' => 'https://jihulab.com/jetsung/pusher',
                'text' => '项目地址',
            ],
            [
                'tag' => 'at',
                'user_id' => 'all',
                'user_name' => '全部人',
            ],
        ];
        $second_content = [
            [
                'tag' => 'img',
                'image_key' => 'img_7ea74629-9191-4176-998c-2e603c9c5e8g',
                'width' => 300,
                'height' => 300,
            ],
        ];
        $third_content = [
            [
                'tag' => 'text',
                'text' => '第二行',
            ],
            [
                'tag' => 'text',
                'text' => '文本测试',
            ],
        ];

        $message = new FeishuMessage('post', '这是一个富文本测试案例');
        $message->setContents([ $first_content ])
            ->addContent($second_content)
            ->addContent($third_content)
            ->addContent($second_content);

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }

    public function testImageCases(): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Feishu();
        $channel->setSecret($this->secret)
            ->setToken($this->token);

        $message = new FeishuMessage('image');
        $message->setImageKey('img_7ea74629-9191-4176-998c-2e603c9c5e8g');

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }

    /**
     * 此接口暂未测试,需"自建应用"有效
     *
     * @return void
     */
    public function testShareChatCases(): void
    {
        $this->skipTest(__METHOD__, true);
        $this->timeSleep(10);

        $channel = new Feishu();
        $channel->setSecret($this->secret)
            ->setToken($this->token);

        $message = new FeishuMessage('share_chat');
        $message->setShareChatID('此功能暂不可用');

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }

    public function testInteractiveCases(): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Feishu();
        $channel->setSecret($this->secret)
            ->setToken($this->token);

        $elements = [
            [
                'tag' => 'div',
                'text' => [
                    'content' => '**西湖**，位于浙江省杭州市西湖区龙井路1号，杭州市区西部，景区总面积49平方千米，汇水面积为21.22平方千米，湖面面积为6.38平方千米。',
                    'tag' => 'lark_md',
                ],
            ],
            [
                'actions' => [
                    [
                        'tag' => 'button',
                        'text' => [
                            'content' => '点击查看项目: 玫瑰:',
                            'tag' => 'lark_md',
                        ],
                        'url' => 'https://jihulab.com/jetsung/pusher',
                        'type' => 'default',
                        'value' => (object) [],
                    ],
                ],
                'tag' => 'action',
            ],
        ];

        $message = new FeishuMessage('interactive');
        $message->setInteractiveConfig([
                'wide_screen_mode' => true,
                'enable_forward' => true,
            ])
            ->setInteractiveHeader([
                'title' => [
                    'content' => '今日旅游推荐',
                    'tag' => 'plain_text',
                ],
            ])
            ->setInteractiveElements($elements);

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }
}
