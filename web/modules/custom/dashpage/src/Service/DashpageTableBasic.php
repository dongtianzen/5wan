<?php

/**
 * @file
 * Contains Drupal\dashpage\Service\DashpageTableBasic.php.
 */

namespace Drupal\dashpage\Service;

/**
 * An example controller.
 $DashpageTableBasic = new DashpageTableBasic();
 $DashpageTableBasic->demoPage();
 */
class DashpageTableBasic {

  /**
   * This function is assigned as Game List Table Thead
   */
  public function getTrendTableThead() {
    $output = array(
      'Date',
      'Tags',
      'Home',
      'Away',
      'Win',
      'Draw',
      'Loss',
      'GoalH',
      'GoalA',
      'Num',
      'Result',
    );

    return $output;
  }

}
