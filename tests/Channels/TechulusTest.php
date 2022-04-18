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
use Pusher\Channel\Techulus;
use Pusher\Message\TechulusMessage;

class TechulusTest extends TestCase
{
    private string $token = '';

    ## 每月只能发 30 条信息，故跳过单元测试
    private static bool $PASS = true;

    public function setUp(): void
    {
        $token = getenv('TechulusToken');
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

    public function additionProvider(): array
    {
        return [
            [ '文本标题一', '不支持 HTML 和 Markdown。项目地址：https://jihulab.com/jetsung/pusher', 'https://jihulab.com/jetsung/pusher', 'https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png'],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $text, string $body, string $link, string $image): void
    {
        $this->skipTest(__METHOD__);

        $channel = new Techulus();
        $channel->setToken($this->token);

        $message = new TechulusMessage($body, $text);
        $message->setLink($link)
            ->setImage($image);

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }
}
