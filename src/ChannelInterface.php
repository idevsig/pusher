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
use Psr\Http\Message\StreamInterface;

interface ChannelInterface
{
    public function configureDefaults(array $config): void;

    public function DEBUG(bool $is_debug): void;

    public function setBaseURL(string $base_url): self;

    public function getBaseURL(): string;

    public function generateURI(): string;

    public function setToken(string $token): self;

    public function getToken(): string;

    public function getContents(): string;

    public function getStatus(): bool;

    public function send(string $method = 'GET', string $uri, array $data = [], array $options = []): ResponseInterface;

    public function request(Message $message): ResponseInterface;

    public function requestContent(Message $message): string;

    public function requestArray(Message $message): array;

    public function showResp(): void;

}
