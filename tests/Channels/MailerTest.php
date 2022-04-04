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
    private string $host = '';
    private int    $port = 0;
    private string $sender = '';
    private string $password = '';
    private string $from_addr = '';
    private string $from_name = '';
    private array  $to_addr = [];

    public const PASS = false;

    public function setUp(): void
    {
        list($this->host, $port) = explode(';', getenv('SMTPHostPort'));
        $this->port = (int) $port;

        list($this->sender, $this->password) = explode(';', getenv('SMTPUser'));

        $from = getenv('SMTPFrom');
        if ($from !== '') {
            list($this->from_addr, $this->from_name) = explode(';', $from);
        }

        $this->to_addr = explode(';', getenv('SMTPTo'));
    }

    public function skipTest(string $func, bool $skip = false): void
    {
        if (self::PASS || $skip) {
            $this->markTestSkipped("skip ${func}");
        }
    }

    public function additionProvider(): array
    {
        return [
            [ '调试 Pusher 邮件发送功能', '这里是邮件 HTML 格式的正文内容，详情 <a href="https://github.com/jetsung/pusher" target="_blank"><strong>点击查看项目网站</strong></a>', '这里是纯文本格式的正文内容'],
            [ '调试 Pusher 邮件发送功能（网页）', file_get_contents('https://getbootstrap.com/docs/5.1/examples/cover/'), '这里是纯文本格式的正文内容'],
        ];
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
            ->setSMTPHostPort($this->host, $this->port)
            ->setSMTPUser($this->sender, $this->password);

        if ($this->from_addr !== '') {
            $channel->setFrom($this->from_addr, $this->from_name);
        }

        if (!empty($this->to_addr)) {
            foreach ($this->to_addr as $addr) {
                $user = explode(':', $addr);
                $channel->addAddress($user[0], $user[1]);
            }
        }

        $message = new MailerMessage($subject, $body, $altBody);

        $channel->requestContent($message);
        $this->assertTrue($channel->getStatus());
    }
}
