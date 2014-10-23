<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$loader = include __DIR__ . '/../vendor/autoload.php';

$loader->addPsr4('TestCommands\\', __DIR__ . '/TestCommands/');