<?php

error_reporting(E_ALL);
define('TESTPATH', __DIR__ . '/');
define('STUBPATH', TESTPATH . 'stubs/');
define('BASEPATH', dirname(TESTPATH) . '/');

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->addPsr4('Inspector\\Test\\', __DIR__ . '/Inspector');
