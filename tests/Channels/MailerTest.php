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

    private static bool $PASS = false;

    public function setUp(): void
    {
        $user = getenv('SMTPUser');
        if ($user) {
            list($sender, $password) = explode(';', getenv('SMTPUser'));
            $this->sender = $sender;
            $this->password = $password;

            list($this->host, $port) = explode(';', getenv('SMTPHostPort'));
            $this->port = (int) $port;

            $from = getenv('SMTPFrom');
            if ($from !== '') {
                list($this->from_addr, $this->from_name) = explode(';', $from);
            }

            $this->to_addr = explode(';', getenv('SMTPTo'));
        } else {
            self::$PASS = true;
        }
    }

    public function skipTest(string $func, bool $skip = false): void
    {
        if (self::$PASS || $skip) {
            $this->markTestSkipped("skip {$func}");
        }
    }

    public static function additionProvider(): array
    {
        $content = file_get_contents('https://getbootstrap.com/docs/5.1/examples/cover/') ?? '';

        return [
            [ 'Pusher通知邮件发送功能', '这里是邮件 HTML 格式的正文内容，详情 <a href="https://github.com/idev-sig/pusher" target="_blank"><strong>点击查看项目网站</strong></a>', '这里是纯文本格式的正文内容'],
            [ 'Pusher通知邮件发送功能（网页）', $content, '这里是纯文本格式的正文内容'],
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

        $message = new MailerMessage($body, $subject, $altBody);

        $channel->request($message);
        $this->assertTrue($channel->getStatus());
    }
}
