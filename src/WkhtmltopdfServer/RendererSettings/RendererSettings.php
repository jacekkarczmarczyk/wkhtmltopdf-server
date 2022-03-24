<?php

namespace WkhtmltopdfServer\RendererSettings;

class RendererSettings
{
    private string $wkhtmltopdfPath;
    private string $cachePath;

    public function __construct(string $wkhtmltopdfPath, string $cachePath)
    {
        $this->wkhtmltopdfPath = $wkhtmltopdfPath;
        $this->cachePath = $cachePath;
    }

    public function getWkhtmltopdfPath(): string
    {
        return $this->wkhtmltopdfPath;
    }

    public function getCachePath(): string
    {
        return $this->cachePath;
    }
}
