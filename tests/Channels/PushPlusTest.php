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
use Pusher\Channel\PushPlus;
use Pusher\Message\PushPlusMessage;

class PushPlusTest extends TestCase
{
    private string $token = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('PushPlusToken');
        if ($token) {
            $this->token = $token;
        } else {
            self::$PASS = true;
        }
    }

    public function skipTest(string $func, bool $skip = false): void
    {
        if (self::$PASS || $skip) {
            $this->markTestSkipped("skip {$func}");
        }
    }

    // 延时
    public function timeSleep(int $time = 5): void
    {
        sleep($time);
    }

    public static function additionProvider(): array
    {
        return [
            [ 'Pusher通知', '一对一，<a href="https://github.com/idev-sig/pusher" target="_blank">项目地址</a>'],
            [ 'Pusher通知', '一对多，<a href="https://github.com/idev-sig/pusher" target="_blank">项目地址</a>', '001'],
            [ 'Pusher通知 JSON', '{"标题": "这个是标题", "消息内容": "这个是消息内容"}', '001', 'json'],
            // [ '标题四 阿里云监控', '一对多推送，<a href="https://github.com/idev-sig/pusher" target="_blank">项目地址</a>', '001', 'cloudMonitor'],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $title, string $content, string $topic = '', string $template = ''): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new PushPlus();
        $channel->setToken($this->token);

        $message = new PushPlusMessage($content, $title);
        $message->setTopic($topic)
            ->setTemplate($template);

        $channel->request($message);

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }
}
