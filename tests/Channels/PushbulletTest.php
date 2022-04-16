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
            [ PushbulletMessage::TYPE_NOTE, '这个是 NOTE 标题', '这个是 NOTE 内容。' ],
            [ PushbulletMessage::TYPE_LINK, '这个是 LINK 标题', '这个是 LINK 内容。', 'https://jihulab.com/jetsung/pusher' ],
            [ PushbulletMessage::TYPE_FILE, '这个是 FILE 标题', '这个是 FILE 内容。', 'https://jihulab.com/jetsung/pusher' ],
        ];
    }

    public function additionOneProvider(): array
    {
        return [
            [ 1, 'ujxWFWA0namsjvRQFTHzOe' ], //  xiaomi ujxWFWA0namsjAGpzVXSbk
            [ 2, 'tests@s.skiy.net'], // 邮箱
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
            $message->setFileName('baidu.png')
                ->setType('image/png')
                ->setFileURL('https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png');
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
                $message->setDeviceIden($iden);
        }

        $channel->request($message);

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }
}
