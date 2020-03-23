<?php

namespace NecId\Endpoints\TenantManagement;

use NecId\Endpoints\Endpoint;

class Application extends Endpoint {

  /**
   * {@inheritdoc}
   */
  public $type = 'tenant_management';

  /**
   * {@inheritdoc}
   */
  public $endpoint = '/api/applications';

  /**
   * Retrieve all applications.
   *
   * @return array
   *  Applications array.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function listApplications() {
    $response = $this->sendRequest('GET');
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

  /**
   * Retrieve application details.
   *
   * @param string $applicationId
   *  Application Id to retrieve.
   *
   * @return array
   *  The application.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function getApplication(string $applicationId) {
    $response = $this->sendRequest('GET', $applicationId);
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

  /**
   * Create an application.
   *
   * @param array $params
   *  Query params to add the gallery. All required.
   *    - 'name': String. Name of the application.
   *    - 'description': String. Description of the application.
   *    - 'faceMinimumQualityScore': Float. Minimum estimated overall quality of
   *       face, must be greater than or equal to 0.45.
   *    - 'galleryId': String. Id of the target gallery.
   *
   * @return array
   *  The application, including ID.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function createApplication(array $params) {
    $this->assertRequiredParams(['name', 'description', 'faceMinimumQualityScore', 'galleryId'], $params);
    $response = $this->sendRequest('POST', '', $params);
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

  /**
   * Update an application.
   *
   * @param string $applicationId
   *  Application Id to update.
   * @param array $params
   *  Params to update the application, all optional but at least one is
   *  required.
   *    - 'name': String. Name of the application.
   *    - 'description': String. Description of the application.
   *    - 'faceMinimumQualityScore': Float. Minimum estimated overall quality of
   *       face, must be greater than or equal to 0.45.
   *
   * @return array
   *   Application data updated.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function updateApplication(string $applicationId, array $params) {
    $this->assertNotEmptyParams($params);
    $response = $this->sendRequest('PATCH', $applicationId, $params);
    return \GuzzleHttp\json_decode($response->getBody(), true);
  }

  /**
   * Deletes an application.
   *
   * @param string $applicationId
   *  Application Id to delete.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function deleteApplication(string $applicationId) {
    $this->sendRequest('DELETE', $applicationId, [], ['204']);
  }

}
