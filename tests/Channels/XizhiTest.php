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
    private string $token_send = 'XZ2ee7814d3d6030bd0090b389124c0761';
    private string $token_channel = 'XZ39d813db544d0669e043c0bcb17fde4d';

    const PASS = false;

    public function skipTest(string $func, bool $skip = false): void
    {

        if (self::PASS || $skip) {
            $this->markTestSkipped("skip ${func}");
        }
    }
    
    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $title, string $content, string $type = 'send'): void
    {
        $this->skipTest(__METHOD__);

        $channel = new Xizhi();

        $token = $type === 'send' ? $this->token_send : $this->token_channel;
        $channel->setType($type)
            ->setToken($token);
        // var_dump($channel);

        $message = new XizhiMessage($title, $content);
        $resp = $channel->requestJson($message);
        // var_dump($resp);

        $this->assertEquals(200, $resp['code']);   
    }

    public function additionProvider(): array
    {
        return [
            [ '单点推送', '**This** is 单点推送. [项目地址](https://github.com/jetsung/pusher)'],
            [ '频道推送', '**This** is 频道推送. [项目地址](https://github.com/jetsung/pusher)', 'channel'],
        ];
    }
}
