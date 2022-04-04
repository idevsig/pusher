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
use Pusher\Channel\WxPusher;
use Pusher\Message\WxPusherMessage;

class WxPusherTest extends TestCase
{
    private string $token = '';

    public const PASS = false;

    public function setUp(): void
    {
        $this->token = getenv('WxPusherToken');
    }

    public function skipTest(string $func, bool $skip = false): void
    {
        if (self::PASS || $skip) {
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
            [
                '「TEXT」Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划',
                '乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
                1,
                [ 5381 ],
                [],
                'https://jihulab.com/jetsung/pusher',
            ],
            [
                '「HTML」<a href="https://apple.com">Apple Store</a> 的<strong>设计</strong>正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划',
                '## 乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
                2,
                [],
                [ 'UID_PRN5fEHFZbhtyv3lyqd3neWlt0q5' ],
                'https://jihulab.com/jetsung/pusher',
            ],
            [
                '「Markdown」[Apple Store](https://apple.com) 的设计正从原来满满的**科技感**走向*生活化*，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划',
                '',
                3,
                [ 5381 ],
                [ 'UID_PRN5fEHFZbhtyv3lyqd3neWlt0q5' ],
                'https://jihulab.com/jetsung/pusher',
            ],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $content, string $summary, int $contentType, array $topicIds, array $uids, string $url): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new WxPusher();
        $channel->setToken($this->token);

        $message = new WxPusherMessage($content);
        $message->setSummary($summary)
            ->setContentType($contentType)
            ->setTopicIds($topicIds)
            ->setUids($uids)
            ->setURL($url);

        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }
}
