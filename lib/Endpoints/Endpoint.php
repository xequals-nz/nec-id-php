<?php

namespace NecId\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use NecId\Resource;

abstract class Endpoint {

  /**
   * @var \GuzzleHttp\ClientInterface
   *  The Guzzle client.
   */
  public $client;

  /**
   * @var array
   *  Request headers.
   */
  public $headers = [];

  /**
   * @var string
   *  Request endpoint.
   */
  public $endpoint = '';

  /**
   * @var string
   *  Request URI.
   */
  public $uri = '';

  /**
   * @var string
   *  Type of endpoint.
   */
  public $type = '';

  /**
   * Endpoint constructor.
   *
   * @throws \Exception
   */
  public function __construct() {
    $this->client = new Client();
    $date = new \DateTime('UTC');
    $this->headers = [
      'x-amz-date' => $date->format('Ymd\THis\Z'),
      'Accept' => 'application/json',
      'Content-Type' => 'application/json',
    ];

    switch ($this->type) {
      case 'tenant_management':
        $this->uri = Resource::$portalEndpoint;
        break;
      case 'biometric':
      default:
      $this->headers['x-api-key'] = Resource::$apiKey;
      $this->uri = Resource::$apiEndpoint;
    }

    $this->uri .= $this->endpoint;
  }

  /**
   * Generic handler for requests.
   *
   * @param string $method
   *  HTTP method.
   * @param string $uri
   *  Fragment to append to the uri.
   * @param array $params
   *  Array of parameters for the request
   * @param array $expectedCodes
   *  Expected response code.
   * @param array $headers
   *  Additional headers to send.
   *
   * @return \Psr\Http\Message\ResponseInterface
   *  Request response
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  protected function sendRequest($method, $uri = '', array $params = [], array $expectedCodes = ['200'], array $headers = []) {
    $uri = $uri ? $this->uri . '/' . $uri : $this->uri;
    $headers = $this->headers + $headers;
    $body = !empty($params) ? \GuzzleHttp\json_encode($params) : '';
    $request = new Request($method, $uri, $headers, $body);
    $signedRequest = Resource::$signature->signRequest($request, Resource::$credentials);
    $response = $this->client->send($signedRequest);
    $this->assertResponseCode($expectedCodes, $response->getStatusCode());

    return $response;
  }

  /**
   * Verifies that the required params are sent to the API.
   *
   * @param array $requiredParams
   *   Parameter names that are required.
   * @param array $params
   *   All parameters.
   */
  protected function assertRequiredParams(array $requiredParams, array $params)  {
    foreach ($requiredParams as $requiredParam) {
      if (!isset($params[$requiredParam])) {
        throw new \InvalidArgumentException(sprintf('The parameter "%s" is required.', $requiredParam));
      }
    }
  }

  /**
   * Verifies that the params sent to the API are not empty.
   *
   * @param array $params
   *   Array of parameters.
   */
  protected function assertNotEmptyParams(array $params)  {
    if (empty($params)) {
      throw new \InvalidArgumentException('Parameters can\'t be empty for this request.');
    }
  }

  /**
   * Asserts the response code is as expected.
   *
   * @param array $expectedCodes
   *   Expected code.
   * @param string $returnedCode
   *   Returned code.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  protected function assertResponseCode($expectedCodes, $returnedCode)  {
    if (!in_array($returnedCode, $expectedCodes)) {
      throw new \GuzzleHttp\Exception\TransferException('Response returned an unexpected code.');
    }
  }

  /**
   * Adds the query params to the uri.
   *
   * @param array $params
   *   Parameters to add.
   */
  protected function addParamsToUri($params) {
    // Because the request is signed, the URL needs to match before and after
    // the client sends it to the server, so the params are added this way
    // instead of using the options array of the send method.
    if (!empty($params)) {
      $this->uri .= '?' . http_build_query($params);
    }
  }

}
