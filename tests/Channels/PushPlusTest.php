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
use Pusher\Channel\PushPlus;
use Pusher\Message\PushPlusMessage;

class PushPlusTest extends TestCase
{
    private string $token = '04805556670c4dd7803762050f1468e2';

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
            [ '标题一', '一对一推送，<a href="https://github.com/jetsung/pusher" target="_blank">项目地址</a>'],
            [ '标题二', '一对多推送，<a href="https://github.com/jetsung/pusher" target="_blank">项目地址</a>', '001'],
            [ '标题三 JSON', '{"code": 0, "message": "success"}', '001', 'json'],
            // [ '标题四 阿里云监控', '一对多推送，<a href="https://github.com/jetsung/pusher" target="_blank">项目地址</a>', '001', 'cloudMonitor'],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $title, string $content, string $topic = '', string $template = ''): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new PushPlus();
        $channel->setToken($this->token);
        // var_dump($channel);

        $message = new PushPlusMessage($title, $content);
        $message->setTopic($topic)
            ->setTemplate($template);

        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }
    
}
