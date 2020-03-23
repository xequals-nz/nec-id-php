<?php

namespace NecId\Endpoints\Biometric;

use NecId\Endpoints\Endpoint;

class Tag extends Endpoint {

  /**
   * {@inheritdoc}
   */
  public $type = 'biometric';

  /**
   * {@inheritdoc}
   */
  public $endpoint = '/tags';

  /**
   * Retrieve all tags for a specific gallery.
   *
   * @return array
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function listTags() {
    $response = $this->sendRequest('GET');
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

  /**
   * Create a tag.
   *
   * @param string name
   *   The tag name. Tag name must not be empty and must be unique. $params
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function createTag(string $name) {
    $this->sendRequest('POST', $name);
  }

  /**
   * Update an existing subject.
   *
   * @param string $oldName
   *  The tag’s current name.
   * @param array $params
   *  Query params to update the tag:
   *    - 'newName': The tag’s new name. Tag name must not be empty and must be
   *                 unique.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function updateTag(string $oldName, array $params = []) {
    $this->assertRequiredParams(['newName'], $params);
    $this->sendRequest('PUT', $oldName, $params);
  }

  /**
   * Deletes a tag. Note that existing subjects and events are not updated.
   *
   * @param string $name
   *  Subject Id to update.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function deleteTag(string $name) {
    $this->sendRequest('DELETE', $name);
  }

}
