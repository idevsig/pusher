<?php declare(strict_types=1);

/*
 * This file is part of Pusher.
 *
 * (c) Jetsung Chan <skiy@jetsung.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pusher;

use Psr\Http\Message\MessageInterface;

class Utils
{
    public static function toArray(MessageInterface $message): array
    {
        $resp = $message->getBody()->getContents();

        return json_decode($resp, true);
    }
}
