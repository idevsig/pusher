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
use Pusher\Channel\Showdoc;
use Pusher\Message\ShowdocMessage;

class ShowdocTest extends TestCase
{
    private string $token = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('ShowdocToken');
        if ($token) {
            $this->token = $token;
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
        $markdown = "![screenshot](https://gw.alicdn.com/tfs/TB1ut3xxbsrBKNjSZFpXXcXhFXa-846-786.png) 
### 乔布斯 20 年前想打造的苹果咖啡厅 
Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划。
**[项目地址](https://github.com/jetsung/pusher)**";

        return [
            [ '这个是标题', $markdown],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $title, string $content): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(5);

        $channel = new Showdoc();
        $channel->setToken($this->token);

        $message = new ShowdocMessage($content, $title);

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }
}
