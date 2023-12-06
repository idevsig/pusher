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

use Exception;
use PHPUnit\Framework\TestCase;
use Pusher\Channel\Telegram;
use Pusher\Message\TelegramMessage;
use Pusher\Pusher;

class TelegramTest extends TestCase
{
    private string $token = '';
    private string $chat_id = '-1001566256525';
    private string $customURL = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('TelegramToken');
        if ($token) {
            $this->token = $token;
        } else {
            self::$PASS = true;
        }

        $customURL = getenv('TelegramCustomURL');
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

    public function additionProvider(): array
    {
        return [
            [ 'Pusher [声音]测试.  项目地址：https://github.com/idev-sig/pusher', true ],
            [ 'Pusher [无声]测试.  项目地址：https://github.com/idev-sig/pusher', false ],
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
        $channel->setChatID($this->chat_id)
            ->setToken($this->token);

        $ping = $this->inChina();
        if ($ping) {
            $channel->setURL($this->customURL);
        }

        $message = new TelegramMessage($text);
        $message->setSound($sound);

        $channel->request($message);

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }

    public function testRoomids(): void
    {
        $this->skipTest(__METHOD__);

        $channel = new Telegram();
        $channel->setChatID($this->chat_id)
            ->setToken($this->token)
            ->setMethod(Pusher::METHOD_GET)
            ->setReqURL('/getUpdates');

        $ping = $this->inChina();
        if ($ping) {
            $channel->setURL($this->customURL);
        }

        $message = new TelegramMessage();

        $response = $channel->request($message);

        if ($channel->getStatus()) {
            $obj = json_decode($response, true);
            foreach ($obj['result'] as $result) {
                if (isset($result['message']) && isset($result['message']['from']['is_bot'])) {
                    if (isset($result['message']['sender_chat'])) {
                        printf("\n\n[ Telegram Bot Id ]: %s", $result['message']['sender_chat']['id']);
                    }
                }
            }
        }

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }

    private function inChina(): bool
    {
        // 使用代理
        // $ping = exec("ping -c 1 api.telegram.org") === ''; // GitHub Action 无法使用
        $ping = false;
        try {
            $opts = [
                'http' => [
                    'method' => 'GET',
                    'timeout' => 5,
                ],
            ];
            $context = stream_context_create($opts);
            file_get_contents('https://api.telegram.org', false, $context);
        } catch (Exception $e) {
            $ping = true;
        }

        return $ping;
    }
}
