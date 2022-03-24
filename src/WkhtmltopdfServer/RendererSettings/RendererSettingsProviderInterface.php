<?php

namespace WkhtmltopdfServer\RendererSettings;

interface RendererSettingsProviderInterface
{
    public function getRendererSettings(): RendererSettings;
}
