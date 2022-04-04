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

use GuzzleHttp\Psr7\Response;

interface ChannelInterface
{
    public function configureDefaults(array $config): void;

    public function setURL(string $base_url): self;

    public function getURL(): string;

    public function setToken(string $token): self;

    public function getToken(): string;

    public function setMethod(string $method): self;

    public function setOptions(array $options): self;

    public function getResponse(): Response;

    public function getContents(): string;

    public function getStatus(): bool;

    public function getErrMessage(): string;

    public function doCheck(Message $message): self;

    public function doAfter(): self;

    public function send(string $method, string $uri, array $data, array $options): Response;

    public function request(Message $message): string;

    public function requestArray(Message $message): array;
}
