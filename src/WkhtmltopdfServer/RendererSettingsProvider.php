<?php

namespace WkhtmltopdfServer;

use InvalidArgumentException;
use SharedTools\HtmlToPdfRenderer\WkhtmltopdfRenderer\WkhtmltopdfRendererSettings;
use SharedTools\HtmlToPdfRenderer\WkhtmltopdfRenderer\WkhtmltopdfRendererSettingsProviderInterface;

class RendererSettingsProvider implements WkhtmltopdfRendererSettingsProviderInterface
{
    /**
     * @var array<mixed>
     */
    private array $settingsArray;

    /**
     * @param array<mixed> $settingsArray
     */
    public function __construct(array $settingsArray)
    {
        $this->settingsArray = $settingsArray;
    }

    public function getRendererSettings(): WkhtmltopdfRendererSettings
    {
        if (!array_key_exists('wkhtmltopdf', $this->settingsArray)) {
            throw new InvalidArgumentException();
        }

        $wkhtmltopdfSettings = is_array($this->settingsArray['wkhtmltopdf']) ? $this->settingsArray['wkhtmltopdf'] : [];

        if (!array_key_exists('path', $wkhtmltopdfSettings) || !array_key_exists('cache', $wkhtmltopdfSettings)) {
            throw new InvalidArgumentException();
        }

        if (!is_string($wkhtmltopdfSettings['path']) || !is_string($wkhtmltopdfSettings['cache'])) {
            throw new InvalidArgumentException();
        }

        return new WkhtmltopdfRendererSettings($wkhtmltopdfSettings['path'], $wkhtmltopdfSettings['cache']);
    }
}
