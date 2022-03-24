<?php

/** @noinspection PhpUnhandledExceptionInspection */

use GuzzleHttp\Psr7\ServerRequest;
use WkhtmltopdfServer\Api;
use WkhtmltopdfServer\ContainerFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = ContainerFactory::createContainer(__DIR__ . '/../src/settings/settings.php');

$api = $container->get(Api::class);
$api->run(ServerRequest::fromGlobals());
