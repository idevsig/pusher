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
use Pusher\Channel\Pushover;
use Pusher\Message\PushoverMessage;

class PushoverTest extends TestCase
{
    private string $token = '';

    private string $user_key = '';
    private string $group_key = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('PushoverToken');
        if ($token) {
            $this->token = $token;
            $this->user_key = getenv('PushoverUserKey');
            $this->group_key = getenv('PushoverGroupKey');
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
            [ '', '这是第一条消息，不指定设备', '', false, 'https://jihulab.com/jetsung/pusher'],
            [ '支持 HTML 的消息', '这是第二条消息，支持HTML。<a href="https://jihulab.com/jetsung/pusher">项目</a>"', '', true, 'https://jihulab.com/jetsung/pusher'],
            [ '第三条信息', '这是第三条消息，不指定设备', 'iphone', false, 'https://jihulab.com/jetsung/pusher'],
            [ '', '这是第四条消息，指定设备<strong>加粗了</strong>', 'Pusher', false, 'https://jihulab.com/jetsung/pusher'],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $title, string $message = '', string $device = '', bool $html = false, string $url = ''): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Pushover();
        $channel->setToken($this->token);

        if ($device === 'Pusher') {
            $channel->setUser($this->group_key);
        } else {
            $channel->setUser($this->user_key);
        }

        $message = new PushoverMessage($message, $title);
        $message->setDevice($device)
            ->setHtml($html)
            ->setURL($url);

        $channel->request($message);

        $status = $channel->getStatus();
        if (!$status) {
            echo $channel->getErrMessage();
        }
        $this->assertTrue($status);
    }
}
