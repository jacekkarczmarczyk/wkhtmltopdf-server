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
    public static function createContainer(string $settingsPath): ContainerInterface
    {
        $container = new Container();
        $container->delegate(new ReflectionContainer());

        $container->add(WkhtmltopdfRendererSettingsProviderInterface::class, fn () => new RendererSettingsProvider($settingsPath));
        /**
         * @psalm-suppress MissingClosureReturnType
         */
        $container->add(HtmlToPdfRendererInterface::class, fn () => $container->get(WkhtmltopdfRenderer::class));

        return $container;
    }
}
