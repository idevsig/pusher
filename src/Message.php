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

class Message implements MessageInterface
{
    protected array $params;

    public function Data(array $data): self
    {
        $this->params = $data;

        return $this;
    }

    public function generateParams(): self
    {
        return $this;
    }

    public function getParams(): array
    {
        if (empty($this->params)) {
            $this->generateParams();
        }

        return $this->params;
    }
}
