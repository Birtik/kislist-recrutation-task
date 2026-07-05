<?php

declare(strict_types=1);

namespace Tests\Books\Utils;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait KernelBrowserHttpClientTrait
{
    private KernelBrowser $httpClient;

    private function setUpHttpClient(): void
    {
        $this->httpClient = self::createClient();
    }

    protected function jsonRequest(
        string $method,
        string $uri,
        ?array $content = null,
        array $server = [],
        array $parameters = [],
        array $files = [],
    ): void {
        $server = array_merge($server, [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json',
        ]);

        $this->httpClient->request(
            $method,
            $uri,
            $parameters,
            $files,
            $server,
            is_array($content) ? json_encode($content) : null,
        );
    }

    public function getHttpClient(): KernelBrowser
    {
        return $this->httpClient;
    }
}