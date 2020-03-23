<?php

require __DIR__ .'/../vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

\NecId\Resource::setCredentials();
$tag = new \NecId\Endpoints\Biometric\Tag();


//print_r($tag->createTag('Test4'));
//print_r($tag->updateTag('Test4b', ['newName' => 'Test4c']));
print_r($tag->deleteTag('Test4c'));
print_r($tag->listTags());


