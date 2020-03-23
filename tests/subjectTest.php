<?php

namespace Tests;

use GuzzleHttp\Tests\Server;
use NecId\Endpoints\Biometric\Subject;

class subjectTest extends \PHPUnit_Framework_TestCase {

  public function setUp() {
    parent::setUp();

    // Load and start the guzzle test server.
    require_once __DIR__ . '/../vendor/guzzlehttp/guzzle/tests/Server.php';
    Server::start();
    register_shutdown_function(
      function () {
        Server::stop();
      }
    );
  }

  /*
   * Tests registering list subjects without the required params.
   */
  public function registerListSubjects() {
    $this->setExpectedException(\InvalidArgumentException::class);
    $subject = new Subject();
    $subject->registerSubject([]);
  }

}
