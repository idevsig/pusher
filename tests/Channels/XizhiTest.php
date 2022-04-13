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

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('XizhiToken');
        $token_channel = getenv('XizhiChannelToken');
        if ($token && $token_channel) {
            $this->token = $token;
            $this->token_channel = $token_channel;
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
            [ '单点推送', '此消息为单点推送. [项目地址](https://github.com/jetsung/pusher)', Xizhi::TYPE_SEND ],
            [ '频道推送', '此消息为频道推送. [项目地址](https://github.com/jetsung/pusher)', Xizhi::TYPE_CHANNEL],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $title, string $content, string $type = ''): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(5);

        $token = $type === Xizhi::TYPE_SEND ? $this->token : $this->token_channel;

        $channel = new Xizhi();
        $channel->setType($type)
            ->setToken($token);

        $message = new XizhiMessage($content, $title);

        $channel->request($message);
        $status = $channel->getStatus();
        if (!$status) {
            var_dump($channel->getErrMessage());
        }
        $this->assertTrue($status);
    }
}
