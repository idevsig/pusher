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
use Pusher\Channel\Chanify;
use Pusher\Message\ChanifyMessage;

class ChanifyTest extends TestCase
{
    private string $token = 'CIDP85UGEiJBRFZUSU5EUVhMWkNDN0RCRko3SUFESkFDQkpCRFRNTlVBIgIIAQ.bew7cDJ0_h7o5R9wvY0HI3SnC0UX4seJaBMntiq8-LI';
 
    private string $url2 = 'http://us2.222029.xyz:39003';
    private string $token2 = 'CIDP85UGEiJBRFZUSU5EUVhMWkNDN0RCRko3SUFESkFDQkpCRFRNTlVBIgIIASoiQUdLSVY0NVkyTlBaRE82S01YSEZINkpSUzJYVzNaUVlVUQ.Q67pfMCHb9HkdKLM5WK6Ws_OSLIBYW4ve5GIFBWEyUU.9O0-4BLdeZPjlelV2yjvQ2HYZsKJ436zO7d7fLRezMo';

    const PASS = false;

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
        $content = "不支持 Markdown 和 HTML。
Pusher 项目地址：https://jihulab.com/jetsung/pusher  
";
        return [
            [ '这里是标题', $content],
            [ '文本，URL', $content, $this->url2],
        ];
    }
    
    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testTextCases(string $title, string $text = '', string $url = ''): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $token = $this->token;
        if ($url !== '') {
            $token = $this->token2;
        }

        $channel = new Chanify();
        $channel->setToken($token);
        // var_dump($channel);

        if ($url !== '') {
            $channel->setBaseURL($url);
        }

        $message = new ChanifyMessage($title, $text);

        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }

    public function testLinkCases(): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Chanify();
        $channel->setToken($this->token);
        // var_dump($channel);

        $message = new ChanifyMessage();
        $message->setSound(1)
            ->setPriority(10)
            ->setLink('https://jihulab.com/jetsung/pusher');

        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }

    public function testActionsCases(): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Chanify();
        $channel->setToken($this->token);
        // var_dump($channel);

        $message = new ChanifyMessage('Actions，URL', '动作消息： Actions');
        $message->setCopy('这个是复制的内容')
            ->setSound(1)
            ->setPriority(10)
            ->setInterruptionLevel('time-sensitive')
            ->setActions(['动作名称1|https://www.baidu.com/?1', '动作名称2|https://www.baidu.com.com/?2'])
            ->addAction('动作名称3|https://www.baidu.com.com/?3');

        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }

    public function testTimelineCases(): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $channel = new Chanify();
        $channel->setToken($this->token);
        // var_dump($channel);

        $timeline = [
            'code' => 'flag',
            'timestamp' => time() * 1000,
            'items' => [
                'key1' => 'value1',
                'key2' => 'value2',
                'key3' => 'value3',
            ],
        ];

        $message = new ChanifyMessage('Timeline，URL', '时间线 Timeline 内容');
        $message->setCopy('这个是复制的内容')
            ->setSound(1)
            ->setPriority(10)
            ->setInterruptionLevel('time-sensitive')
            ->setTimeline($timeline);

        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }

}
