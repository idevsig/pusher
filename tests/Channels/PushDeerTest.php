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
use Pusher\Channel\PushDeer;
use Pusher\Message\PushDeerMessage;

class PushDeerTest extends TestCase
{
    private string $token = 'PDU5530TH1sn4HMhMdIJjc8pMxpIMPKnGMTJcgvX';

    const PASS = false;

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
            [ 'This is text', 'This is desp', ''],
            [ '## Markdown', '**Markdown** 类型数据. [项目地址](https://jihulab.com/jetsung/pusher)', 'markdown'],
            [ 'https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png', '', 'image'],
            [ '## 自定义', '**自定义 URL** 类型.', 'markdown', 'https://api2.pushdeer.com/'],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $text, string $desp = '', $type = '', $base_url = ''): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new PushDeer();
        $channel->setToken($this->token);
        // var_dump($channel);

        if ($base_url !== '') {
            $channel->setBaseURL($base_url);
        }
        // var_dump($channel->getBaseURL());

        $message = new PushDeerMessage($text, $desp, $type);

        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }

}
