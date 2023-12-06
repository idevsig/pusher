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
        $user_key = getenv('PushoverUserKey');
        $group_key = getenv('PushoverGroupKey');
        if ($token && ($user_key || $group_key)) {
            $this->token = $token;
            $this->user_key = $user_key;
            $this->group_key = $group_key;
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
            [ 'Pusher通知', 'Pusher通知第一条消息，指定User', 'User', false, 'https://github.com/idev-sig/pusher'],
            [ 'Pusher通知支持 HTML 的消息', 'Pusher通知第二条消息，指定User，支持HTML。<strong>加粗了</strong> <a href="https://github.com/idev-sig/pusher">项目</a>"', 'User', true, 'https://github.com/idev-sig/pusher'],
            [ 'Pusher通知第三条信息', 'Pusher通知第三条消息，指定设备「iphone」', 'iphone', false, 'https://github.com/idev-sig/pusher'],
            [ 'Pusher通知', 'Pusher通知第四条消息，指定群组「Pusher」', 'Group', false, 'https://github.com/idev-sig/pusher'],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $title, string $message = '', string $mode = '', bool $html = false, string $url = ''): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Pushover();
        $channel->setToken($this->token);

        if (!$mode) {
            $this->assertTrue(false);
        }

        if ($mode === 'Group') { // group
            $channel->setUser($this->group_key);
        } elseif ($mode === 'User') {
            $channel->setUser($this->user_key);
        } else {
            $channel->setUser($this->group_key);
            $channel->setUser($this->user_key);
        }

        $message = new PushoverMessage($message, $title);
        $message->setHtml($html)
            ->setURL($url);

        if (!in_array($mode, ['User', 'Group'])) {
            $message->setDevice($mode);
        }

        $channel->request($message);

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }
}
