<?php

use SharedTools\ArrayMerger\ArrayMerger;

$instanceName = trim(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '_instance.txt') ?: '');
$instanceFile = __DIR__ . DIRECTORY_SEPARATOR . "instance.{$instanceName}.php";

/**
 * @psalm-suppress UnresolvableInclude
 */
$instanceSettings = require $instanceFile;
if (!is_array($instanceSettings)) {
    throw new InvalidArgumentException();
}

return ArrayMerger::mergeRecursiveDistinct([
    'wkhtmltopdf' => [
        'path' => '/usr/bin/wkhtmltopdf',
        'cache' => realpath(__DIR__ . '/../../cache'),
    ],
    'errorReporting' => false,
    'apiKey' => '',
], $instanceSettings);
