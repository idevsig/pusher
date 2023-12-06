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
use Pusher\Channel\Pushbullet;
use Pusher\Message\PushbulletMessage;

class PushbulletTest extends TestCase
{
    private string $token = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('PushbulletToken');
        if ($token) {
            $this->token = $token;
        } else {
            self::$PASS = true;
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
            [ PushbulletMessage::TYPE_NOTE, 'Pusher通知 NOTE 标题', '这个是 NOTE 内容。' ],
            [ PushbulletMessage::TYPE_LINK, 'Pusher通知 LINK 标题', '这个是 LINK 内容。', 'https://github.com/idev-sig/pusher' ],
            [ PushbulletMessage::TYPE_FILE, 'Pusher通知 FILE 标题', '这个是 FILE 内容。', 'https://github.com/idev-sig/pusher' ],
        ];
    }

    public static function additionOneProvider(): array
    {
        return [
            // [ 9, 'ujxWFWA0namsjvRQFTHzOe' ], //  Android Idenkey
            [ 2, 'snowany@outlook.com'], // 邮箱
            // [ 4, 'client_iden' ], // client iden 无法测
            // [ 5, 'channel_tag' ], // channel_tag 无法测
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $type, string $title, string $body, string $url = ''): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Pushbullet();
        $channel->setToken($this->token);

        $message = new PushbulletMessage($type, $body, $title);

        if ($type === PushbulletMessage::TYPE_LINK) {
            $message->setURL($url);
        } elseif ($type === PushbulletMessage::TYPE_FILE) {
            $message->setFileName('meinv.png')
                ->setType('image/png')
                ->setFileURL('https://tse3-mm.cn.bing.net/th/id/OIP-C.NXnqTLAq_jjNimN3iiqVEAHaQD');
        }

        $channel->request($message);

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }

    /**
     * @dataProvider additionOneProvider
     *
     * @return void
     */
    public function testOneCases(int $num, string $iden): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Pushbullet();
        $channel->setToken($this->token);

        $message = new PushbulletMessage(PushbulletMessage::TYPE_NOTE, '这个是消息内容： ' . $num, '标题');

        switch ($num) {
            case 1:
                $message->setDeviceIden($iden);
                break;

            case 2:
                $message->setEmail($iden);
                break;

            case 4:
                $message->setClientIden($iden);
                break;

            case 5:
                $message->setChannelTag($iden);
                break;

            default:
                $this->assertTrue(false);
        }

        $channel->request($message);

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }
}
