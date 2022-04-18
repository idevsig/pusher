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
use Pusher\Channel\Mattermost;
use Pusher\Message\MattermostMessage;
use Pusher\Pusher;

class MattermostTest extends TestCase
{
    private string $user_id = 'pusher';
    private string $password = '';
    private string $channel_id = 'juf9zdwxitgsfy1jbbaysrf6za';

    private string $custom_token = '';
    private string $custom_url = '';
    private string $custom_channel_id = 'yoegaynokffk7xd9ky9w8kyqdc';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $custom_token = getenv('MattermostCustomToken');
        $custom_url = getenv('MattermostCustomURL');
        if ($custom_token && $custom_url) {
            $this->custom_token = $custom_token;
            $this->custom_url = $custom_url;
        } else {
            self::$PASS = true;
        }

        $this->password = getenv('MattermostPassword');
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
        $channel->setChannelID($this->custom_channel_id)
            ->setToken($this->custom_token)
            ->setURL($this->custom_url);

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
        $channel->setToken($this->custom_token)
            ->setURL($this->custom_url)
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

    // username password
    public function testUserPwdCases(): string
    {
        if (!$this->password) {
            $this->skipTest(__METHOD__, true);
        }

        $channel = new Mattermost();
        $channel->setReqURL('/api/v4/users/login');

        $message = new MattermostMessage();
        $message->Data([
            'login_id' => $this->user_id,
            'password' => $this->password,
        ]);

        $response = $channel->request($message);

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());

        return $channel->getResponse()->getHeader('token')[0];
    }

    /**
     * @depends testUserPwdCases
     */
    public function testCommunityCases(string $token): void
    {
        // $this->skipTest(__METHOD__);
        // $this->assertNotEmpty($token);

        $channel = new Mattermost();
        $channel->setChannelID($this->channel_id)
            ->setToken($token);

        $message = new MattermostMessage('这个是 Community Mattermost 通知消息。项目地址：https://jihulab.com/jetsung/pusher');

        $channel->request($message);

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }
}
