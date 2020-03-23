<?php

namespace NecId\Endpoints\Biometric;

use NecId\Endpoints\Endpoint;
use GuzzleHttp\Psr7\Request;
use NecId\Resource;

class Subject extends Endpoint {

  /**
   * {@inheritdoc}
   */
  public $type = 'biometric';

  /**
   * {@inheritdoc}
   */
  public $endpoint = '/subjects';

  /**
   * Lists the subjects.
   *
   * @param array $params
   *  Query params to filter the listing based on the API:
   *    - 'start': Optional starting index of the request, defaults to 0 if not
   *               provided.
   *    - 'length': Optional length of the list, defaults to 1000 if not
   *                provided. Limited to a maximum of 1000 per request.
   *    - 'dir': Optional last updated sort direction (asc or desc). default is
   *             asc.
   *
   * @return array
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function listSubjects(array $params = []) {
    if (!empty($params)) {
      $endpoint = $this->uri . '?' . http_build_query($params);
      $request = new Request('GET', $endpoint, $this->headers);
      $signedRequest = Resource::$signature->signRequest($request, Resource::$credentials);
      $response = $this->client->send($signedRequest);
      $this->assertResponseCode(['200'], $response->getStatusCode());
    }
    else {
      $response = $this->sendRequest('GET');
    }
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

  /**
   * Registers a subject.
   *
   * @param array $params
   *  Query params to add the subject:
   *    - 'face': Base64 encoded image.
   *    - 'tags': Array. Optional list of tag names to register against the
   *              subject.
   *
   * @return array
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function registerSubject(array $params = []) {
    $this->assertRequiredParams(['face'], $params);
    $response = $this->sendRequest('POST', '', $params, ['201']);
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

  /**
   * Update an existing subject.
   *
   * @param string $subjectId
   *  Subject Id to update.
   * @param array $params
   *  Query params to update the subject:
   *    - 'face': Base64 encoded image.
   *    - 'tags': Array. Optional list of tag names to register against the
   *              subject.
   *
   * @return array
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function updateSubject(string $subjectId, array $params = []) {
    $this->assertRequiredParams(['face'], $params);
    $response = $this->sendRequest('PUT', $subjectId, $params);
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

  /**
   * Unregister an existing subject and related events.
   *
   * @param string $subjectId
   *  Subject Id to delete.
   *
   * @return array
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function unregisterSubject(string $subjectId) {
    try {
      $this->sendRequest('DELETE', $subjectId, [], ['204', '404']);
    }
    catch (\GuzzleHttp\Exception\GuzzleException $e) {
      if ($e->getCode() == 404) {
        return ['message' => 'Subject not found'];
      }
      else {
        throw $e;
      }
    }
    return ['message' => 'Subject unregistered successfully'];
  }

}
