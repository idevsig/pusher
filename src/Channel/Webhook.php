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

class Webhook extends \Pusher\Channel
{
    public function __construct(array $config = [])
    {
        parent::configureDefaults($config);
    }

    public function setReqURL(string $url): self
    {
        $this->request_url = $url;

        return $this;
    }
}
