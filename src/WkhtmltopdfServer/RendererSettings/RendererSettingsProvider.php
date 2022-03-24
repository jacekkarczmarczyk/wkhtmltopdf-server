<?php

namespace WkhtmltopdfServer\RendererSettings;

use InvalidArgumentException;
use RuntimeException;

class RendererSettingsProvider implements RendererSettingsProviderInterface
{
    private string $settingsPath;

    public function __construct(string $settingsPath)
    {
        $this->settingsPath = $settingsPath;
    }

    public function getRendererSettings(): RendererSettings
    {
        if (!is_readable($this->settingsPath)) {
            throw new RuntimeException('Settings file not found');
        }
        /**
         * @psalm-suppress UnresolvableInclude
         */
        $settings = require $this->settingsPath;
        if (!is_array($settings)) {
            throw new InvalidArgumentException();
        }

        if (!array_key_exists('wkhtmltopdf', $settings)) {
            throw new InvalidArgumentException();
        }

        $wkhtmltopdfSettings = is_array($settings['wkhtmltopdf']) ? $settings['wkhtmltopdf'] : [];

        if (!array_key_exists('path', $wkhtmltopdfSettings) || !array_key_exists('cache', $wkhtmltopdfSettings)) {
            throw new InvalidArgumentException();
        }

        if (!is_string($wkhtmltopdfSettings['path']) || !is_string($wkhtmltopdfSettings['cache'])) {
            throw new InvalidArgumentException();
        }

        return new RendererSettings($wkhtmltopdfSettings['path'], $wkhtmltopdfSettings['cache']);
    }
}
