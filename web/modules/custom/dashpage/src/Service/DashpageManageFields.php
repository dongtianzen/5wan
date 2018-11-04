<?php

/**
 * @file
 * Contains Drupal\dashpage\Service\DashpageManageFields.php.
 */

namespace Drupal\dashpage\Service;

/**
 * An example controller.
 $DashpageManageFields = new DashpageManageFields();
 $DashpageManageFields->demoPage();
 */
class DashpageManageFields {

  /**
   *
   */
  public function getNodeWinField() {
    $output = [
      array(
        'type' => 'value',
        'field' => 'field_win_date_time'
      ),
      array(
        'type' => 'term',
        'field' => 'field_win_tags'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_name_home'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_name_away'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_ave_win'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_ave_draw'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_ave_loss'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_goal_home'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_goal_away'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_num_company'
      ),
    ];

    return $output;
  }

  /**
   *
   */
  public function getNodeWinAllFields() {
    $output = [
      array(
        'type' => 'value',
        'field' => 'field_win_date_time'
      ),
      array(
        'type' => 'term',
        'field' => 'field_win_tags'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_name_home'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_name_away'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_ave_win'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_ave_draw'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_ave_loss'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_ini_win'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_ini_draw'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_ini_loss'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_goal_home'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_goal_away'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_num_company'
      ),
    ];

    return $output;
  }

}
