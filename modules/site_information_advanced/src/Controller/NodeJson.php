<?php

namespace Drupal\site_information_advanced\Controller;

use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Response;

/**
 *  Controller to get JSON representation of any node.
 */
class NodeJson {

  /**
   * Display the node JSON.
   */
  public function nodeJson($site_api_key, $id) {
    // Serializer service to encode data.
    $serializer = \Drupal::service('serializer');
    // Get site api key from updated site information form.
    $siteapikey = \Drupal::config('system.site')->get('siteapikey');
    $node = Node::load($id);
    $json_data = NULL;
    // Check site api key getting from url is same as entered in site information form.
    if ($siteapikey === $site_api_key) {
      $json_data = $serializer->serialize($node, 'json', ['plugin_id' => 'entity']);
      \Drupal::logger('site_information_advanced')->info('JSON is created for =>' . $id);
    }else{
      \Drupal::logger('site_information_advanced')->info('Tried to create JSON using wrong url.');
    }
    $response = new Response();
    $response->setContent($json_data);
    return $response;
  }

}
