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
use Pusher\Channel\Mailer;
use Pusher\Message\MailerMessage;

class MailerTest extends TestCase
{

    const PASS = false;

    public function skipTest(string $func, bool $skip = false): void
    {

        if (self::PASS || $skip) {
            $this->markTestSkipped("skip ${func}");
        }
    }
    
    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $subject = '', string $body = '', string $altBody = ''): void
    {
        $this->skipTest(__METHOD__);

        $channel = new Mailer();

        $channel->setSMTPDebug(false)
            ->setSMTPAuth(true)
            ->setSMTPSecure()
            ->setSMTPHostPort('smtp.exmail.qq.com', 465)
            ->setSMTPUser('tests@s.skiy.net', 'A13579a');


        $channel->setFrom('tests@s.skiy.net', 'Pusher')
            ->addAddress('jetsung@outlook.com', 'Jetsung Chan'); 

        $message = new MailerMessage($subject, $body, $altBody);
        
        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }

    public function additionProvider(): array
    {
        return [
            [ '调试 Pusher 邮件发送功能', '这里是邮件 HTML 格式的正文内容，详情 <a href="https://github.com/jetsung/pusher" target="_blank"><strong>点击查看项目网站</strong></a>', '这里是纯文本格式的正文内容'],
            [ '调试 Pusher 邮件发送功能（网页）', file_get_contents('https://getbootstrap.com/docs/5.1/examples/cover/'), '这里是纯文本格式的正文内容'],
        ];
    }
    
}
