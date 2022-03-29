<?php declare(strict_types=1);

/*
 * This file is part of Pusher.
 *
 * (c) Jetsung Chan <skiy@jetsung.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pusher\Channel;

use Psr\Http\Message\ResponseInterface;
use Pusher\Message;

class WeCom extends \Pusher\Channel
{
    private string $secret = '';

    protected string $base_url = 'https://qyapi.weixin.qq.com';
    protected string $uri_template = '%s/cgi-bin/webhook/send?key=%s';

    public function __construct(array $config = [])
    {        
        parent::configureDefaults($config);
        $this->client = new \GuzzleHttp\Client();
    }

    public function request(Message $message): ResponseInterface
    {
        $request_uri = sprintf($this->uri_template, $this->config['base_url'], $this->getToken());
        $postData = $message->getParams();

        return $this->client->request('POST', $request_uri, [ 'json' => $postData ]);
    }

}
