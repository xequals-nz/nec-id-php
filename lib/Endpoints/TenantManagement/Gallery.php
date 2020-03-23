<?php

namespace NecId\Endpoints\TenantManagement;

use NecId\Endpoints\Endpoint;

class Gallery extends Endpoint {

  /**
   * {@inheritdoc}
   */
  public $type = 'tenant_management';

  /**
   * {@inheritdoc}
   */
  public $endpoint = '/api/galleries';

  /**
   * Retrieve all galleries.
   *
   * @return array
   *  Galleries array.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function listGalleries() {
    $response = $this->sendRequest('GET');
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

  /**
   * Retrieve gallery details.
   *
   * @param string $galleryId
   *  Gallery Id to retrieve.
   *
   * @return array
   *  The gallery, including associated applications and apiKey.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function getGallery(string $galleryId) {
    $response = $this->sendRequest('GET', $galleryId);
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

  /**
   * Create a gallery and an application with which to access it.
   *
   * @param array $params
   *  Query params to add the gallery. All required.
   *    - 'name': String. Name of the gallery.
   *    - 'description': String. Description of the gallery.
   *    - 'faceMinimumQualityScore': Float. Minimum estimated overall quality of
   *       face, must be greater than or equal to 0.45.
   *    - 'size': Int. Size of the gallery.
   *
   * @return array
   *  The gallery, including associated applications and apiKey.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function createGallery(array $params) {
    $this->assertRequiredParams(['name', 'description', 'faceMinimumQualityScore', 'size'], $params);
    $response = $this->sendRequest('POST', '', $params);
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

  /**
   * Update a gallery.
   *
   * @param string $galleryId
   *  Gallery Id to update.
   * @param array $params
   *  Query params to filter the listing based on the API, all optional but at
   *  least one is required.
   *    - 'name': String. Name of the application.
   *    - 'description': String. Description of the application.
   *    - 'size': Int. Size of the gallery.
   *
   * @return array
   *   Gallery data updated.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function updateGallery(string $galleryId, array $params = []) {
    $this->assertNotEmptyParams($params);
    $response = $this->sendRequest('PATCH', $galleryId, $params);
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

  /**
   * Deletes a gallery.
   *
   * @param string $galleryId
   *  Gallery Id to delete.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function deleteGallery(string $galleryId) {
    $this->sendRequest('DELETE', $galleryId, [], ['204']);
  }

}
