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
use Pusher\Channel\Webhook;
use Pusher\Message\WebhookMessage;

class WebhookTest extends TestCase
{
    private string $get_token = '';
    private string $post_token = '';
    private string $post_json_token = '';

    const PASS = false;

    public function setUp(): void
    {
        $this->get_token = getenv('WebhookTokenGet');
        $this->post_token = getenv('WebhookTokenPost');
        $this->post_json_token = getenv('WebhookTokenPostJSON');
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
            [ 'get', [ 'text' => '[PushDeer]这个是 WebHook 消息内容。' ]],
            [ 'post', [ 'text' => '[Chanify]这个是 WebHook 消息内容。' ]],
            [ 'post_json', [ 'title' => '这个是 POST_JSON 标题', 'content' => '[PushPlus]这个是 WebHook 消息内容。' ]],
        ];
    }

    /**
     * @dataProvider additionProvider
     *
     * @return void
     */
    public function testCases(string $method, array $data = []): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $method = strtoupper($method);

        $channel = new Webhook();
        $channel->setMethod($method);

        $token = '';
        if ($method === 'POST_JSON') {
            list($url, $token) = explode(';', $this->post_json_token);
            $data['token'] = $token;
        } else if ($method === 'POST') {
            list($url, $token) = explode(';', $this->post_token);
            $data['token'] = $token;
        } else {
            $url = sprintf('%s&%s', $this->get_token, http_build_query($data));
        }
        $channel->setBaseURL($url);
 
        $message = new WebhookMessage($data);

        $resp = $channel->request($message);
        $this->assertEquals(200, $resp->getStatusCode());
    }

}
