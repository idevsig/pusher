<?php declare(strict_types=1);

/*
 * This file is part of Pusher.
 *
 * (c) Jetsung Chan <jetsungchan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pusher\Tests\Channels;

use PHPUnit\Framework\TestCase;
use Pusher\Channel\Chanify;
use Pusher\Message\ChanifyMessage;

class ChanifyTest extends TestCase
{
    private string $token = '';
    private string $customURL = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('ChanifyToken');
        if ($token) {
            $this->token = $token;
        } else {
            self::$PASS = true;
        }

        $customURL = getenv('ChanifyCustomURL');
        if ($customURL) {
            $this->customURL = $customURL;
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

    public function additionProvider(): array
    {
        $content = "不支持 Markdown 和 HTML。
Pusher 项目地址：https://github.com/idev-sig/pusher
";

        return [
            [ '这里是标题', $content],
            [ '文本，自定义 URL', $content, true],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testTextCases(string $title, string $text = '', bool $is_custom = false): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Chanify();
        $channel->setToken($this->token);

        if ($is_custom) {
            $channel->setURL($this->customURL);
        }

        $message = new ChanifyMessage($title, $text);

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }

    public function testLinkCases(): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Chanify();
        $channel->setToken($this->token);

        $message = new ChanifyMessage();
        $message->setSound(1)
            ->setPriority(10)
            ->setLink('https://github.com/idev-sig/pusher');

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }

    public function testActionsCases(): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Chanify();
        $channel->setToken($this->token);

        $message = new ChanifyMessage('Actions', '动作消息： Actions');
        $message->setCopy('这个是复制的内容')
            ->setSound(1)
            ->setPriority(10)
            ->setInterruptionLevel('time-sensitive')
            ->setActions(['动作名称1|https://www.baidu.com/?1', '动作名称2|https://www.baidu.com.com/?2'])
            ->addAction('动作名称3|https://www.baidu.com.com/?3');

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }

    public function testTimelineCases(): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Chanify();
        $channel->setToken($this->token);

        $timeline = [
            'code' => 'flag',
            'timestamp' => time() * 1000,
            'items' => [
                'key1' => 'value1',
                'key2' => 'value2',
                'key3' => 'value3',
            ],
        ];

        $message = new ChanifyMessage('Timeline', '时间线 Timeline 内容');
        $message->setCopy('这个是复制的内容')
            ->setSound(1)
            ->setPriority(10)
            ->setInterruptionLevel('time-sensitive')
            ->setTimeline($timeline);

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }
}
