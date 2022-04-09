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
use Pusher\Channel\NowPush;
use Pusher\Message\NowPushMessage;

class NowPushTest extends TestCase
{
    private string $token = '';

    public const PASS = false;

    public function setUp(): void
    {
        $this->token = getenv('NowPushToken');
    }

    public function skipTest(string $func, bool $skip = false): void
    {
        if (self::PASS || $skip) {
            $this->markTestSkipped("skip ${func}");
        }
    }

    public function additionProvider(): array
    {
        return [
            [ 'nowpush_note', '这个是 Note 推送的消息。项目地址：https://jihulab.com/jetsung/pusher', 'api', '' ],
            [ 'nowpush_img', '这个是 Note 推送的消息。', 'mobile', 'https://www.nowpush.app/assets/img/welcome/welcome-mockup.png' ],
            [ 'nowpush_link', '这个是 Note 推送的消息。', 'browser', '项目地址：https://jihulab.com/jetsung/pusher' ],
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
