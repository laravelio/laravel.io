<?php
// This is global bootstrap for autoloading

include __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/start.php';
$app->boot();
