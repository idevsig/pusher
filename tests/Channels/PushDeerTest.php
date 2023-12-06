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
        $token = getenv("PushDeerToken");
        if ($token) {
            $this->token = $token;
        } else {
            self::$PASS = true;
        }

        $customURL = getenv('PushDeerCustomURL');
        if ($customURL) {
            $this->customURL = $customURL;
        }
    }

    public function skipTest(string $func, bool $skip = false): void
    {
        if (self::$PASS || $skip) {
            $this->markTestSkipped("skip {$func}");
        }
    }

    // 延时
    public function timeSleep(int $time = 5): void
    {
        sleep($time);
    }

    public static function additionProvider(): array
    {
        return [
            [ '', 'Pusher通知', 'This is desp' ],
            [ PushDeerMessage::TYPE_MARKDOWN, '## Pusher通知Markdown', '**Markdown** 类型数据. [项目地址](https://github.com/idev-sig/pusher)' ],
            [ PushDeerMessage::TYPE_IMAGE,  'https://tse3-mm.cn.bing.net/th/id/OIP-C.NXnqTLAq_jjNimN3iiqVEAHaQD', '' ],
            [ PushDeerMessage::TYPE_TEXT, 'Pusher通知自定义内容', '自定义文本内容描述.', true ],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $type = '', string $text = '', string $desp = '', bool $is_custom = false): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new PushDeer();
        $channel->setToken($this->token);

        if ($is_custom) {
            $channel->setURL($this->customURL);
        }

        $message = new PushDeerMessage($type, $desp, $text);

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }
}
