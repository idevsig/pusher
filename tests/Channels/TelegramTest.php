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
use Pusher\Channel\Telegram;
use Pusher\Message\TelegramMessage;

class TelegramTest extends TestCase
{
    private string $token = '';
    private string $chat_id = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('TelegramToken');
        $chat_id = getenv('TelegramToken');
        if ($token && $chat_id) {
            $this->token = $token;
            $this->chat_id = $chat_id;
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
            [ 'Pusher [声音]测试.  项目地址：https://jihulab.com/jetsung/pusher', true ],
            [ 'Pusher [无声]测试.  项目地址：https://jihulab.com/jetsung/pusher', false ],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $text, bool $sound = false): void
    {
        $this->skipTest(__METHOD__);

        $channel = new Telegram();
        $channel->setToken($this->token);

        // 使用代理
        if (!exec("ping -c 1 www.google.com")) {
            $channel->setOptions([
                'proxy' => [
                    'http' => 'http://127.0.0.1:1088',
                    'https' => 'http://127.0.0.1:1088',
                ],
            ]);
        }

        $message = new TelegramMessage($text);
        $message->setChatID($this->chat_id)
            ->setSound($sound);

        $channel->request($message);

        echo "\n";
        var_dump($channel->getErrMessage(), $channel->getContents());
        $this->assertTrue($channel->getStatus());
    }
}
