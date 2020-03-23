<?php

namespace NecId\Endpoints\Biometric;

use NecId\Endpoints\Endpoint;

class Face extends Endpoint {

  /**
   * {@inheritdoc}
   */
  public $type = 'biometric';

  /**
   * {@inheritdoc}
   */
  public $endpoint = '/face';

  /**
   * Extract face attributes.
   *
   * @param array $params
   *    - 'faces': String. Base64 encoded image containing one or more faces.
   *    - 'limit': Int. Optional limit of total faces returned, default is 10.
   *               Note, if the time taken to retrive the faces is beyond 30
   *               seconds, the request will timeout.
   *
   * @return array
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function extract(array $params = []) {
    $this->assertRequiredParams(['faces'], $params);
    $response = $this->sendRequest('POST', 'extract', $params);
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

  /**
   * Verify a face against a probe or subject.
   *
   * @param array $params
   *    - 'face': String. Base64 encoded image.
   *    - 'probe': String. Base64 encoded image.
   *  OR
   *    - 'probe': String. Base64 encoded image.
   *    - 'id': String. Subject id.
   *
   * @return array
   *  Array with a "score" key displaying the matching score and an optional id.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function verify(array $params = []) {
    $this->assertRequiredParams(['probe'], $params);
    $response = $this->sendRequest('POST', 'verify', $params);
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

  /**
   * Search for subjects using a probe.
   *
   * @param array $params
   *    - 'probe': String. Base64 encoded image.
   *    - 'threshold': Int. Optional score threshold, ranges from 0 to 9999,
   *                   default is 7000.
   *    - 'limit': Int. Optional limit of total events returned, ranges from 1
   *               to 50, default is 10.
   *    - 'tags': Array. Option list of tag names to refine the search against,
   *              using OR to filter subjects.
   *
   * @return array
   *   Array of subject candidates with score and attributes of the face.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function search(array $params = []) {
    $this->assertRequiredParams(['probe'], $params);
    $response = $this->sendRequest('POST', 'search', $params);
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

}
