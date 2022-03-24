<?php

declare(strict_types=1);

namespace WkhtmltopdfServer;

use League\Container\Container;
use League\Container\ReflectionContainer;
use Psr\Container\ContainerInterface;
use WkhtmltopdfServer\RendererSettings\RendererSettingsProvider;
use WkhtmltopdfServer\RendererSettings\RendererSettingsProviderInterface;

class ContainerFactory
{
    public static function createContainer(string $settingsPath): ContainerInterface
    {
        $container = new Container();
        $container->delegate(new ReflectionContainer());

        $container->add(RendererSettingsProviderInterface::class, fn () => new RendererSettingsProvider($settingsPath));

        return $container;
    }
}
