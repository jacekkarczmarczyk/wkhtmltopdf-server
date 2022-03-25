<?php

declare(strict_types=1);

namespace WkhtmltopdfServer;

use League\Container\Container;
use League\Container\ReflectionContainer;
use Psr\Container\ContainerInterface;
use SharedTools\HtmlToPdfRenderer\HtmlToPdfRendererInterface;
use SharedTools\HtmlToPdfRenderer\WkhtmltopdfRenderer\WkhtmltopdfRenderer;
use SharedTools\HtmlToPdfRenderer\WkhtmltopdfRenderer\WkhtmltopdfRendererSettingsProviderInterface;

class ContainerFactory
{
    /**
     * @param array<mixed> $settingsArray
     * @return ContainerInterface
     */
    public static function createContainer(array $settingsArray): ContainerInterface
    {
        $container = new Container();
        $container->delegate(new ReflectionContainer());

        $container->addShared(WkhtmltopdfRendererSettingsProviderInterface::class, fn () => new RendererSettingsProvider($settingsArray));
        /**
         * @psalm-suppress MissingClosureReturnType
         */
        $container->addShared(HtmlToPdfRendererInterface::class, fn () => $container->get(WkhtmltopdfRenderer::class));
        /**
         * @psalm-suppress MixedArgument
         */
        $container->addShared(ApiKeyProvider::class, fn () => new ApiKeyProvider($settingsArray['apiKey']));

        return $container;
    }
}
