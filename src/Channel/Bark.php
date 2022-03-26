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

class Bark extends \Pusher\Channel
{
    protected string $base_url = 'https://api.day.app';
    protected string $uri_template = '%s/%s';

    public function __construct(array $config = [])
    {
        $this->client = new \GuzzleHttp\Client();

        parent::configureDefaults($config);
    }

    public function request(Message $message): ResponseInterface
    {
        $request_uri = sprintf($this->uri_template, $this->config['base_url'], $this->getToken());
        $postData = $message->getParams();

        return $this->client->request('POST', $request_uri, [ 'form_params' => $postData]);
    }

}
