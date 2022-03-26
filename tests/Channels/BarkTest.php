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
use Pusher\Channel\Bark;
use Pusher\Message\BarkMessage;

class BarkTest extends TestCase
{
    private string $token = 'PuUNrs3tmnqVQ54Q6iRLmg';

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
        string $base_url = ''): void
    {
        $channel = new Bark();
        $channel->setToken($this->token);
        // var_dump($channel);

        if ($base_url !== '') {
            $channel->setBaseURL($base_url);
        }
        // var_dump($channel->getBaseURL());

        $message = new BarkMessage($title, $body, $badge, $sound, $icon, $group, $url);
        $resp = $channel->requestJson($message);
        // var_dump($resp);

        $this->assertEquals(200, $resp['code']);
    }

    public function additionProvider(): array
    {
        return [
            [ 'This is text', 'This is desp'],
            [ '标题', '内容', 1, 'bloom.caf', 'http://www.pushdeer.com/images/2022-02-03-17-55-30.png'],
            [ '标题222', '分组，内容222', 1, 'bloom.caf', '', 'group'],
            [ '标题333', '分组，跳转到百度', 1, 'chime.caf', '', 'group', 'https://www.baidu.com'],
            [ '标题444', '分组2，跳转到百度，自定义URL', 2, 'chime.caf', '', 'group2', 'https://www.baidu.com', 'https://api.day.app'],
        ];
    }
}
