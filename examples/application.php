<?php

require __DIR__ .'/../vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

\NecId\Resource::setCredentials();
$application = new \NecId\Endpoints\TenantManagement\Application();

//print_r($application->createApplication([
//  'name' => 'Application Test',
//  'description' => 'Application Test desc',
//  'faceMinimumQualityScore' => 0.6,
//  'galleryId' => 'cc5272f1-cc5b-4719-9a42-44b74c9e95af',
//]));

print_r($application->listApplications());


//print_r($application->getApplication('htqo7kf8gc'));
//print_r($application->updateApplication('htqo7kf8gc', ['faceMinimumQualityScore' => 0.6]));


