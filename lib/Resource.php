<?php

namespace NecId;

use Aws\Credentials\Credentials;
use Aws\Signature\SignatureV4;

class Resource {

  /**
   * @var string
   *  The API key.
   */
  public static $apiKey;

  /**
   * @var string
   *  The API endpoint.
   */
  public static $apiEndpoint;

  /**
   * @var string
   *  The API endpoint.
   */
  public static $portalEndpoint;

  /**
   * @var \Aws\Signature\SignatureInterface
   *  The Credentials object from AWS.
   */
  public static $signature;

  /**
   * @var \Aws\Credentials\CredentialsInterface
   *  The Credentials object from AWS.
   */
  public static $credentials;


  /**
   * Sets the credentials and signature ready for requests.
   *
   * @param array $accessInfo
   *   Access information.
   */
  public static function setCredentials($accessInfo = []) {
    // Configuration defaults to environment, but overridden by the parameter.
    $accessInfo += [
      'access_key' => getenv('ACCESS_KEY'),
      'secret_key' => getenv('SECRET_KEY'),
      'region' => getenv('AWS_REGION'),
      'api_endpoint' => getenv('API_ENDPOINT'),
      'api_key' => getenv('API_KEY'),
      'portal_endpoint' => getenv('PORTAL_ENDPOINT'),
    ];

    self::$apiKey = $accessInfo['api_key'];
    self::$apiEndpoint = $accessInfo['api_endpoint'];
    self::$portalEndpoint = $accessInfo['portal_endpoint'];

    self::$signature = new SignatureV4('execute-api', $accessInfo['region']);
    self::$credentials = new Credentials($accessInfo['access_key'], $accessInfo['secret_key']);
  }

}
