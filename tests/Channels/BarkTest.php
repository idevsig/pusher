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
use Pusher\Channel\Bark;
use Pusher\Message\BarkMessage;

class BarkTest extends TestCase
{
    private string $token = '';
    private string $customURL = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $token = getenv("BarkToken");
        if ($token) {
            $this->token = $token;
        } else {
            self::$PASS = true;
        }

        $customURL = getenv('BarkCustomURL');
        if ($customURL) {
            $this->customURL = $customURL;
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
            [ '标题000', '这是标题000的内容。'],
            [ '标题111', '111自定义声音和ICON', 1, 'bloom.caf', 'https://www.baidu.com/img/PCtm_d9c8750bed0b3c7d089fa7d55720d6cf.png'],
            [ '标题222', '分组，内容222', 1, 'bloom.caf', '', 'group'],
            [ '标题333', '分组，跳转到项目地址', 1, 'chime.caf', '', 'group', 'https://github.com/idev-sig/pusher'],
            'custom url' => [ '自定义 URL 标题', '分组2，跳转到项目地址，自定义URL', 2, 'chime.caf', '', 'group2', 'https://github.com/idev-sig/pusher', true ],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(
        string $title,
        string $body,
        int    $badge = 1,
        string $sound = '',
        string $icon = '',
        string $group = '',
        string $url = '',
        bool $is_custom = false
    ): void {
        $this->skipTest(__METHOD__);
        $this->timeSleep(5);

        $channel = new Bark();
        $channel->setToken($this->token);

        if ($is_custom) {
            if ($this->customURL === '') {
                $this->skipTest(__METHOD__, true);
            }

            $channel->setURL($this->customURL);
        }

        $message = new BarkMessage($body);
        $message->setTitle($title)
            ->setBadge($badge)
            ->setCopy($body)
            ->setSound($sound)
            ->setIcon($icon)
            ->setGroup($group)
            ->setURL($url);

        $channel->request($message);

        echo "\n";
        if (!$channel->getStatus()) {
            var_dump($channel->getErrMessage());//, $channel->getContents());
        }
        $this->assertTrue($channel->getStatus());
    }
}
