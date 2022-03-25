<?php

declare(strict_types=1);

namespace WkhtmltopdfServer;

use Exception;
use Psr\Http\Message\ServerRequestInterface;
use SharedTools\HtmlToPdfRenderer\HtmlToPdfRendererInterface;

class Api
{
    private HtmlToPdfRendererInterface $renderer;
    private ApiKeyProvider $apiKeyProvider;

    public function __construct(HtmlToPdfRendererInterface $renderer, ApiKeyProvider $apiKeyProvider)
    {
        $this->renderer = $renderer;
        $this->apiKeyProvider = $apiKeyProvider;
    }

    /**
     * @throws Exception
     */
    public function run(ServerRequestInterface $serverRequest): void
    {
        /** @var array{filename: string, html:string, landscape: boolean, apiKey: string} $parsedBody */
        $parsedBody = json_decode($serverRequest->getBody()->getContents(), true);

        if ($parsedBody['apiKey'] !== $this->apiKeyProvider->getApiKey()) {
            throw new Exception('Invalid API key');
        }

        $contents = $this->renderer->render($parsedBody['html'], $parsedBody['landscape']);

        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename=file.pdf');

        echo $contents;
    }
}
