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
use Pusher\Channel\Xizhi;
use Pusher\Message\XizhiMessage;

class XizhiTest extends TestCase
{
    private string $token = '';
    private string $token_channel = '';

    public const PASS = false;

    public function setUp(): void
    {
        $this->token = getenv('XizhiToken');
        $this->token_channel = getenv('XizhiChannelToken');
    }

    public function skipTest(string $func, bool $skip = false): void
    {
        if (self::PASS || $skip) {
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
            [ '单点推送', '**This** is 单点推送. [项目地址](https://github.com/jetsung/pusher)'],
            [ '频道推送', '**This** is 频道推送. [项目地址](https://github.com/jetsung/pusher)', 'channel'],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $title, string $content, string $type = 'send'): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(5);

        $token = $type === 'send' ? $this->token : $this->token_channel;

        $channel = new Xizhi();
        $channel->setType($type)
            ->setToken($token);

        $message = new XizhiMessage($title, $content);

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }
}
