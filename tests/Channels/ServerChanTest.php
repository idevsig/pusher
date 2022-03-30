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
use Pusher\Channel\ServerChan;
use Pusher\Message\ServerChanMessage;

class ServerChanTest extends TestCase
{
    private string $token = 'SCT93860TKEl9jxBc5XvHg4pgXdJ9GcRs';

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $text, string $desp = ''): void
    {
        $channel = new ServerChan();
        $channel->setToken($this->token);
        // var_dump($channel);

        $message = new ServerChanMessage($text, $desp);
        $resp = $channel->requestJson($message);
        // var_dump($resp);

        $this->assertEquals(0, $resp['data']['errno']);   
    }

    public function additionProvider(): array
    {
        return [
            [ 'Title', '**This** is desp. [官网](https://jetsung.com)'],
        ];
    }
}
