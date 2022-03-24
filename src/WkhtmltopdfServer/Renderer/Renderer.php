<?php

declare(strict_types=1);

namespace WkhtmltopdfServer\Renderer;

use Knp\Snappy\Pdf;
use RuntimeException;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use WkhtmltopdfServer\RendererSettings\RendererSettingsProviderInterface;

class Renderer
{
    private RendererSettingsProviderInterface $rendererSettingsProvider;

    public function __construct(RendererSettingsProviderInterface $rendererSettingsProvider)
    {
        $this->rendererSettingsProvider = $rendererSettingsProvider;
    }

    /**
     * @throws TimeoutException
     */
    public function render(string $html, bool $landscape): string
    {
        $settings = $this->rendererSettingsProvider->getRendererSettings();

        // @todo https://github.com/KnpLabs/KnpSnappyBundle/issues/149
        $pdf = new Pdf($settings->getWkhtmltopdfPath(), [
            'enable-local-file-access' => true, // https://stackoverflow.com/questions/62315246/wkhtmltopdf-0-12-6-warning-blocked-access-to-file
        ]);
        $inputFile = $settings->getCachePath() . DIRECTORY_SEPARATOR . uniqid('Wkhtmltopdf-input-', true) . '.html';
        $outputFile = $settings->getCachePath() . DIRECTORY_SEPARATOR . uniqid('Wkhtmltopdf-output-', true) . '.pdf';

        if (false === file_put_contents($inputFile, $html)) {
            throw new RuntimeException("Could not write to {$inputFile}");
        }

        $options = ['lowquality' => false];
        if ($landscape) {
            $options['orientation'] = 'landscape';
        }

        try {
            $pdf->generate($inputFile, $outputFile, $options);
            $content = @file_get_contents($outputFile);
            if ($content === false) {
                throw new RuntimeException('Could not generate PDF');
            }
            return $content;
        } catch (ProcessTimedOutException $exception) {
            throw new TimeoutException('Przekroczono limit czasu na wygenerowanie pliku PDF.');
        } finally {
            @unlink($inputFile);
            @unlink($outputFile);
        }
    }
}
