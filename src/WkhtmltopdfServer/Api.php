<?php

declare(strict_types=1);

namespace WkhtmltopdfServer;

use Exception;
use Psr\Http\Message\ServerRequestInterface;
use WkhtmltopdfServer\Renderer\Renderer;

class Api
{
    private Renderer $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @throws Exception
     */
    public function run(ServerRequestInterface $serverRequest): void
    {
        /** @var array{filename: string, html:string, landscape: boolean} $parsedBody */
        $parsedBody = json_decode($serverRequest->getBody()->getContents(), true);

        $contents = $this->renderer->render($parsedBody['html'], $parsedBody['landscape']);

        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename=file.pdf');

        echo $contents;
    }
}
