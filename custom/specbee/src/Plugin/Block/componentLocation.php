<?php
namespace Drupal\specbee\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\specbee\CurrentTime;

/**
* Provides a block with a simple text.
*
* @Block(
*   id = "component_location",
*   admin_label = @Translation("Custom Block : Site Location"),
*   category = "SPECBEE"
* )
*/

class componentLocation extends BlockBase {

  public function __construct()
  {
    $this->timeService = new CurrentTime();
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node     = \Drupal::routeMatch()->getParameter('node');
    $config   = \Drupal::config('specbee.adminsettings');
    $country  = $config->get('country');
    $city     = $config->get('city');
    $datetime = $this->timeService->getTime();
    
    $data = array(
      '#theme' => 'component_location',
      'title' => isset($node) ? $node->getTitle() : 'Site Location and Time',
      'country' => $country,
      'city' => $city,
      'time' => $datetime,
      '#cache' => array(
        //'max-age' => 0,
        'contexts' =>  ['node'],
        'tags' => isset($node) ? $node->getCacheTags() : '',
      ),
    );
    
    return $data;

   }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}
