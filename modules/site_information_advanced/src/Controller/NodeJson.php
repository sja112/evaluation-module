<?php

namespace Drupal\site_information_advanced\Controller;

use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Response;

/**
 *  Controller for page node to get Json.
 */
class NodeJson {

  /**
   * {@inheritdoc}
   */
  public function nodeJson($site_api_key, $id) {
    $serializer = \Drupal::service('serializer');
    $siteapikey = \Drupal::config('system.site')->get('siteapikey');
    $node = Node::load($id);
    $json_data = NULL;
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
