<?php
// This is global bootstrap for autoloading

include __DIR__.'/../vendor/autoload.php';

// $kernel = \AspectMock\Kernel::getInstance();
// $kernel->init([
//     'debug' => true,
//     'cacheDir' => '/tmp/l4-sample',
//     'includePaths' => [__DIR__.'/../../vendor/laravel', __DIR__.'/../app']
// ]);

$app = require_once __DIR__.'/../bootstrap/start.php';

//\Codeception\Util\Autoload::registerSuffix('Page', __DIR__.DIRECTORY_SEPARATOR.'_pages');
