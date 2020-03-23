<?php

require __DIR__ .'/../vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

\NecId\Resource::setCredentials();
$gallery = new \NecId\Endpoints\TenantManagement\Gallery();


//print_r($gallery->getGallery('cc5272f1-cc5b-4719-9a42-44b74c9e95af'));


//print_r($gallery->createGallery([
//  'name' => 'Test Gallery',
//  'description' => 'Gallery created for testing',
//  'faceMinimumQualityScore' => 0.6,
//  'size' => 1000,
//]));


print_r($gallery->updateGallery('0967aa46-b2b0-4c5b-81f8-3b0b1134663b', ['size' => 1100]));


print_r($gallery->listGalleries());
