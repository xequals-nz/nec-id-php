<?php

require __DIR__ .'/../vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

\NecId\Resource::setCredentials();
$face = new \NecId\Endpoints\Biometric\Face();
