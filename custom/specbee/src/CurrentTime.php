<?php
namespace Drupal\specbee;

class CurrentTime {

  public function getTime() {
    $time = \Drupal::time()->getCurrentTime();
    $datetime = date('jS M Y - g:i A', $time);
    return $datetime;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}  