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
use Pusher\Channel\Webhook;
use Pusher\Message\WebhookMessage;
use Pusher\Pusher;

class WebhookTest extends TestCase
{
    private string $get_token = '';
    private string $post_token = '';
    private string $post_json_token = '';

    private static bool $PASS = false;

    public function setUp(): void
    {
        $get_token = getenv('WebhookTokenGet');
        $post_token = getenv('WebhookTokenPost');
        $post_json_token = getenv('WebhookTokenPostJSON');
        if ($get_token && $post_token && $post_json_token) {
            $this->get_token = $get_token;
            $this->post_token = $post_token;
            $this->post_json_token = $post_json_token;
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

    // 延时
    public function timeSleep(int $time = 5): void
    {
        sleep($time);
    }

    public static function additionProvider(): array
    {
        return [
            [ Pusher::METHOD_GET, [ 'text' => 'Pusher通知[PushDeer]这个是 WebHook 消息内容。' ]],
            [ Pusher::METHOD_POST, [ 'text' => 'Pusher通知[Chanify]这个是 WebHook 消息内容。' ]],
            [ Pusher::METHOD_JSON, [ 'title' => 'Pusher通知[PushPlus]这个是 POST_JSON 标题', 'content' => '[PushPlus]这个是 WebHook 消息内容。' ]],
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
        if ($method === Pusher::METHOD_JSON) {
            list($url, $token) = explode(';', $this->post_json_token);
            $data['token'] = $token;
        } elseif ($method === Pusher::METHOD_POST) {
            list($url, $token) = explode(';', $this->post_token);
            $data['token'] = $token;
        } else {
            $url = sprintf('%s&%s', $this->get_token, http_build_query($data));
        }
        $channel->setReqURL($url);

        $message = new WebhookMessage($data);

        $channel->request($message);
        $this->assertEquals(200, $channel->getResponse()->getStatusCode());
    }

    public function testQQBotCases(): void
    {
        $this->skipTest(__METHOD__);
        $this->timeSleep(10);

        $token = getenv('QQBotToken');
        $app_id = getenv('QQBotAppId');
        if (!$token || !$app_id) {
            $this->skipTest(__METHOD__, true);
        }

        $options = [
            'headers' => [
                'Authorization' => sprintf('Bot %s.%s', $app_id, $token),
            ],
        ];

        $uri = 'https://sandbox.api.sgroup.qq.com/users/@me/guilds';
        $channel = new Webhook();
        $channel->setReqURL($uri)
            ->setMethod(Pusher::METHOD_GET)
            ->setOptions($options);

        $message = new WebhookMessage();

        $channel->request($message);
        $this->assertEquals(200, $channel->getResponse()->getStatusCode());
    }
}
