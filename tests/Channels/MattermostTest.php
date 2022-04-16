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
use Pusher\Channel\Mattermost;
use Pusher\Message\MattermostMessage;
use Pusher\Pusher;

class MattermostTest extends TestCase
{
    private string $token = '';
    private string $customURL = '';
    private string $channel_id = '3tzmjwfsxig6jfibteh9b7z1ae';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv('MattermostToken');
        $customURL = getenv('MattermostCustomURL');
        if ($token && $customURL) {
            $this->token = $token;
            $this->customURL = $customURL;
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

        $channel = new Mattermost();
        $channel->setChannelID($this->channel_id)
            ->setToken($this->token)
            ->setURL($this->customURL);

        $message = new MattermostMessage('这个是 Mattermost 通知消息。项目地址：https://jihulab.com/jetsung/pusher');

        $channel->request($message);

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }

    public function testChannelsCases(): void
    {
        $this->skipTest(__METHOD__);

        $channel = new Mattermost();
        $channel->setToken($this->token)
            ->setURL($this->customURL)
            ->setMethod(Pusher::METHOD_GET)
            ->setReqURL('/api/v4/channels');

        $message = new MattermostMessage();

        $response = $channel->request($message);

        if ($channel->getStatus()) {
            $obj = json_decode($response, true);
            foreach ($obj as $data) {
                printf("\n\n[ Mattermost Channel Id ]: %s \nName: %s\n", $data['id'], $data['name']);
            }
        }

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }
}
