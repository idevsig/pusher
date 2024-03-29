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
use Pusher\Channel\PushBack;
use Pusher\Message\PushBackMessage;

class PushBackTest extends TestCase
{
    private string $token = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('PushBackToken');
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

    public static function additionProvider(): array
    {
        return [
            [ 'Pusher通知 User', '[用户方式]本[项目地址](https://github.com/idev-sig/pusher)', 'User_1857', '左侧', '右侧', '回复些消息'],
            [ 'Pusher通知 Channel', '[通道方式]本[项目地址](https://github.com/idev-sig/pusher)', 'Channel_2421', '左侧', '右侧', '回复些消息'],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $title, string $body = '', string $id = '', string $action1 = '', string $action2 = '', string $reply = ''): void
    {
        $this->skipTest(__METHOD__);

        $channel = new PushBack();
        $channel->setToken($this->token);

        $message = new PushBackMessage($body, $title);
        $message->setID($id)
            ->setAction1($action1)
            ->setAction2($action2)
            ->setReply($reply);

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }
}
