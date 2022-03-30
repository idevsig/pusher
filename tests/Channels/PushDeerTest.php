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
use Pusher\Channel\PushDeer;
use Pusher\Message\PushDeerMessage;

class PushDeerTest extends TestCase
{
    private string $token = 'PDU5530TH1sn4HMhMdIJjc8pMxpIMPKnGMTJcgvX';

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $text, string $desp = '', $type = '', $base_url = ''): void
    {
        $channel = new PushDeer();
        $channel->setToken($this->token);
        // var_dump($channel);

        if ($base_url !== '') {
            $channel->setBaseURL($base_url);
        }
        // var_dump($channel->getBaseURL());

        $message = new PushDeerMessage($text, $desp, $type);
        $resp = $channel->requestJson($message);
        // var_dump($resp);

        $count = count($resp['content']['result']);
        $this->assertNotEquals(0, $count);
    }

    public function additionProvider(): array
    {
        return [
            [ 'This is text', 'This is desp', ''],
            [ '## This is text', '**This** is desp. [项目地址](https://github.com/jetsung/pusher)', 'markdown'],
            [ 'http://www.pushdeer.com/images/2022-02-03-17-55-30.png', '', 'image'],
            [ '## This is text', '**This** is custom url.', 'markdown', 'https://api2.pushdeer.com/'],
        ];
    }
}
