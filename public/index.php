<?php

/** @noinspection PhpUnhandledExceptionInspection */

use GuzzleHttp\Psr7\ServerRequest;
use WkhtmltopdfServer\Api;
use WkhtmltopdfServer\ContainerFactory;

require __DIR__ . '/../vendor/autoload.php';

/** @var array<mixed> $settings */
$settings = file_get_contents(__DIR__ . '/../src/settings/settings.php');
$container = ContainerFactory::createContainer($settings);

$errorReporting = $settings['errorReporting'];
error_reporting($errorReporting ? E_ALL : 0);
ini_set('display_startup_errors', $errorReporting ? '1' : '0');
ini_set('display_errors', $errorReporting ? '1' : '0');
ini_set('assert.exception', $errorReporting ? '1' : '0');

$api = $container->get(Api::class);
$api->run(ServerRequest::fromGlobals());
