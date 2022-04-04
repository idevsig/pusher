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
use Pusher\Channel\ServerChan;
use Pusher\Message\ServerChanMessage;

class ServerChanTest extends TestCase
{
    private string $token = '';

    ## ServerChan 每天只能发 5 条信息，故跳过单元测试
    public const PASS = true;

    public function setUp(): void
    {
        $this->token = getenv('ServerChanToken');
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
            [ 'Title', '**This** is desp. [项目地址](https://jihulab.com/jetsung/pusher)'],
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

        $message = new ServerChanMessage($text, $desp);

        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }
}
