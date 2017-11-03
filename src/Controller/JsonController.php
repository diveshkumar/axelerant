<?php

namespace Drupal\axelerant\Controller;

use Drupal\Core\Url;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Config\ConfigManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class JsonController for exposing Node Data in JSON format.
 */
class JsonController extends ControllerBase {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Drupal\Component\Serialization\Json definition.
   *
   * @var \Drupal\Component\Serialization\Json
   */
  protected $serializationJson;

  /**
   * Drupal\Core\Config\ConfigManager definition.
   *
   * @var \Drupal\Core\Config\ConfigManager
   */
  protected $configManager;

  /**
   * Constructs a new JsonController object.
   */
  public function __construct(EntityTypeManager $entity_type_manager, Json $serialization_json, ConfigManager $config_manager) {
    $this->entityTypeManager = $entity_type_manager;
    $this->serializationJson = $serialization_json;
    $this->configManager = $config_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('entity_type.manager'), $container->get('serialization.json'), $container->get('config.manager'));
  }

  /**
   * This method returns the Node JSON based on site API Key that is configured
   *  through admin configurations & a valid node ID.
   *
   * @return JSON
   *   Returns Node Data otherwise Error Information.
   */
  public function getPageJson($site_api_key, $node_id) {
    // Getting Site API Key that was configured earlier.
    $configured_site_api_key = $this->configManager->getConfigFactory()->getEditable('axelerant.settings')->get('site_api_key');
    // Show access denied if URL API key does not matches with configured one.
    if ($configured_site_api_key == $site_api_key && (!empty($node_id) && is_numeric($node_id))) {
      // Getting Node Data by node id.
      $node_data = $this->entityTypeManager->getStorage('node')->load($node_id);

      // Checking if $node_data variable is null then respond with an error message.
      if (empty($node_data)) {
        return new JsonResponse(["error" => t("Invalid Node ID Provided")]);
      }
      // Returning JSON formatted Data.
      return new JsonResponse($node_data->toArray());
    }
    // If not matching the URL & configured API keys then redirect to 403.
    $url = Url::fromRoute('system.403');
    // Redirection is getting ready for Access Denied Page.
    $response = new RedirectResponse($url->toString());

    return $response;
  }

}
