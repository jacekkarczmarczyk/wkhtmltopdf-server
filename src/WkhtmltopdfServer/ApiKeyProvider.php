<?php

declare(strict_types=1);

namespace WkhtmltopdfServer;

class ApiKeyProvider
{
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
