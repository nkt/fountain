<?php

/** @var \Composer\Autoload\Classloader $autoload */
$autoload = require __DIR__ . '/../vendor/autoload.php';

$autoload->addPsr4('Fountain\\Test\\', __DIR__, true);
