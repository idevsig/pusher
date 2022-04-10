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
    private string $token = '';
    private string $customURL = '';
    private string $customToken = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('PushDeerToken');
        if ($token) {
            $this->token = $token;
            $this->customURL = getenv('PushDeerCustomURL');
            $this->customToken = getenv('PushDeerCustomToken');
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
            [ 'This is text', 'This is desp', ''],
            [ '## Markdown', '**Markdown** 类型数据. [项目地址](https://jihulab.com/jetsung/pusher)', 'markdown'],
            [ 'https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png', '', 'image'],
            [ '## 自定义', '**自定义 URL** 类型.', 'markdown', true],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $text, string $desp = '', string $type = '', bool $is_custom = false): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new PushDeer();
        $channel->setToken($this->token);

        if ($is_custom) {
            $channel->setURL($this->customURL)
                ->setToken($this->customToken);
        }

        $message = new PushDeerMessage($text, $desp, $type);

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }
}
