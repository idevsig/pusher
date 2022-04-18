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
use Pusher\Channel\NowPush;
use Pusher\Message\NowPushMessage;

class NowPushTest extends TestCase
{
    private string $token = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('NowPushToken');
        if ($token) {
            $this->token = $token;
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

    public function additionProvider(): array
    {
        return [
            [ NowPushMessage::TYPE_NOTE, '这个是 Note 推送的消息。项目地址：https://jihulab.com/jetsung/pusher', 'api', '' ],
            [ NowPushMessage::TYPE_IMG, '这个是 Note 推送的消息。', 'mobile', 'https://www.nowpush.app/assets/img/welcome/welcome-mockup.png' ],
            [ NowPushMessage::TYPE_LINK, '这个是 Note 推送的消息。', 'browser', '项目地址：https://jihulab.com/jetsung/pusher' ],
            [ '', '这是一条自定义类型的消息。', 'Test', 'https://jihulab.com/jetsung/pusher' ],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $message_type, string $note = '', string $device_type = '', string $url = ''): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new NowPush();
        $channel->setToken($this->token);

        $message = new NowPushMessage($message_type);
        $message->setNote($note)
            ->setDeviceType($device_type)
            ->setURL($url);

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }
}
