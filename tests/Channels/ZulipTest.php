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
use Pusher\Channel\Zulip;
use Pusher\Message\ZulipMessage;
use Pusher\Pusher;

class ZulipTest extends TestCase
{
    private string $email = '';
    private string $api_key = '';
    private string $customURL = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $customURL = getenv('ZulipCustomURL');
        $email = getenv('ZulipEmail');
        $api_key = getenv('ZulipApiKey');
        if ($customURL && $email && $api_key) {
            $this->email = $email;
            $this->api_key = $api_key;
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

    // 延时
    public function timeSleep(int $time = 5): void
    {
        sleep($time);
    }

    public function additionProvider(): array
    {
        return [
            [ ZulipMessage::TYPE_PRIVATE, 'tests@s.skiy.net', '私人、邮箱、字符串 **支持 Markdown**。[项目地址](https://jihulab.com/jetsung/pusher)' ],
            [ ZulipMessage::TYPE_PRIVATE, '[ 494729, 494731 ]', '私人、ID、数字列表 **支持 Markdown**。[项目地址](https://jihulab.com/jetsung/pusher)' ],
            [ ZulipMessage::TYPE_STREAM, 322046, '流、频道、数字 **支持 Markdown**。[项目地址](https://jihulab.com/jetsung/pusher)', 'Pusher' ],
            [ ZulipMessage::TYPE_STREAM, 'general', '流、频道、频道名 **支持 Markdown**。[项目地址](https://jihulab.com/jetsung/pusher)', 'Pusher' ],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $type, string|int $to = '', string $content = '', string $topic = ''): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(5);

        $channel = new Zulip();
        $channel->setEmail($this->email)
            ->setApiKey($this->api_key)
            ->setURL($this->customURL);

        $message = new ZulipMessage($type, $content);
        $message->setTo($to)
            ->setTopic($topic);

        $channel->request($message);

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }

    public function testStreamsCases(): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(5);

        $channel = new Zulip();
        $channel->setReqURL('/api/v1/users/me/subscriptions')
            ->setEmail($this->email)
            ->setApiKey($this->api_key)
            ->setURL($this->customURL)
            ->setMethod(Pusher::METHOD_GET);

        $message = new ZulipMessage();

        $response = $channel->request($message);

        if ($channel->getStatus()) {
            $obj = json_decode($response, true);

            if (isset($obj['subscriptions'])) {
                foreach ($obj['subscriptions'] as $streams) {
                    printf("\n\n[ Zulip Stream Id ]: %s\nName: %s\n", $streams['stream_id'], $streams['name']);
                }
            }
        }

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }
}
