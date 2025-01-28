<?php

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$appLogger = new Logger('app');
$appLogger->pushHandler(new StreamHandler('./log/app.log', Level::Debug));

$apiLogger = new Logger('api');
$apiLogger->pushHandler(new StreamHandler('./log/api.log', Level::Debug));
