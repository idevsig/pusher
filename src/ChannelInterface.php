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

use Psr\Http\Message\ResponseInterface;

interface ChannelInterface
{
    public function configureDefaults(array $config): void;

    public function setBaseURL(string $base_url): self;

    public function getBaseURL(): string;

    public function generateURI(): string;

    public function setToken(string $token): self;

    public function getToken(): string;

    public function request(Message $message): ResponseInterface;

    public function requestJson(Message $message): array;

    public function requestString(Message $message): string;
}
