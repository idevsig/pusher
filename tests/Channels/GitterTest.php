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
use Pusher\Channel\Gitter;
use Pusher\Message\GitterMessage;
use Pusher\Pusher;

class GitterTest extends TestCase
{
    private string $token = '';
    private string $room_id = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('GitterToken');
        $room_id = getenv('GitterRoomId');
        if ($token && $room_id) {
            $this->token = $token;
            $this->room_id = $room_id;
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

    public function testCases(): void
    {
        $this->skipTest(__METHOD__);

        $channel = new Gitter();
        $channel->setRoomID($this->room_id)
            ->setToken($this->token);

        $message = new GitterMessage('这个是 Gitter 通知消息。项目地址：https://jihulab.com/jetsung/pusher');

        $channel->request($message);

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }

    public function testRoomsCases(): void
    {
        $this->skipTest(__METHOD__);

        $channel = new Gitter();
        $channel->setReqURL('/v1/rooms')
            ->setMethod(Pusher::METHOD_GET)
            ->setToken($this->token);

        $message = new GitterMessage();

        $response = $channel->request($message);

        if ($channel->getStatus()) {
            $obj = json_decode($response, true);
            foreach ($obj as $data) {
                printf("\n\n[ Gitter Room Id ]: %s \nName: %s\n", $data['id'], $data['name']);
            }
        }

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }
}
