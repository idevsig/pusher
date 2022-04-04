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

interface MessageInterface
{
    public function Data(array $data): self;

    public function generateParams(): self;

    public function getParams(): array;
}
