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
use Pusher\Channel\Miaomiao;
use Pusher\Message\MiaomiaoMessage;

class MiaomiaoTest extends TestCase
{
    private string $token = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('MiaomiaoToken');
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

    public function testCases(): void
    {
        $this->skipTest(__METHOD__);

        $channel = new Miaomiao();
        $channel->setToken($this->token);

        $message = new MiaomiaoMessage('这个是喵喵通知消息。项目地址：https://jihulab.com/jetsung/pusher');

        $channel->request($message);
        $status = $channel->getStatus();
        if (!$status) {
            var_dump($channel->getErrMessage());
        }
        $this->assertTrue($status);
    }
}
