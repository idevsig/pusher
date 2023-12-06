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
use Pusher\Channel\ServerChan;
use Pusher\Message\ServerChanMessage;

class ServerChanTest extends TestCase
{
    private string $token = '';

    ## ServerChan 每天只能发 5 条信息，故跳过单元测试
    private static bool $PASS = true;

    public function setUp(): void
    {
        $token = getenv('ServerChanToken');
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
            [ 'Title', '**This** is desp. [项目地址](https://github.com/idev-sig/pusher)'],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $text, string $desp = ''): void
    {
        $this->skipTest(__METHOD__);

        $channel = new ServerChan();
        $channel->setToken($this->token);

        $message = new ServerChanMessage($desp, $text);

        $channel->request($message);

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }
}
