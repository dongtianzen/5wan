<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/mongo//src/Content/ManageContent.php');

  $ManageContent = new ManageContent();
  $ManageContent->runInsert();
 */

/**
 * Execute a database query
 *
 * http://zetcode.com/db/mongodbphp/
 */

use Drupal\Component\Utility\Timer;

/**
 *
 */
class ManageContent {

  /**
   *
   */
  public function getWinFields() {
    $output = array(
      "num" => "num_company",
      "outlier" => "outlier",
      "e_win" => "ave_win",     // end
      "e_draw" => "ave_draw",
      "e_loss" => "ave_loss",
      "i_win" => "ini_win",     // ini
      "i_draw" => "ini_draw",
      "i_loss" => "ini_loss",
      "ve_win" => "variation_end_win",     // variation_end
      "ve_draw" => "variation_end_draw",
      "ve_loss" => "variation_end_loss",
      "vi_win" => "variation_ini_win",
      "vi_draw" => "variation_ini_draw",
      "vi_loss" => "variation_ini_loss",
    );

    return $output;
  }

  /**
   *
   */
  public function getNids() {
    $query = \Drupal::entityQuery('node');

    $query->condition('status', 1);
    $query->condition('type', 'win');
    $query->range(0, 10000);      // from 10, total 10

    $result = $query->execute();

    return array_values($result);
  }

  /**
   *
   */
  public function runInsert() {
    $win_fields = $this->getWinFields();
    $nids = $this->getNids();

    $name = 'time_one';
    Timer::start($name);

    foreach ($nids as $key => $nid) {
      $row = array();
      $row['game_id'] = intval($nid);

      foreach ($win_fields as $key => $field) {
        $query = $this->dbSelectFieldsValue(
          $nid,
          'node__field_win_' . $field,
          'field_win_' . $field . '_value'
        );

        if (current($query)) {
          if ($field == 'num_company') {
            $row[$key] = intval(current($query));
          }
          elseif ($field == 'outlier') {
            $row[$key] = intval(current($query));
          }
          else {
            $row[$key] = floatval(current($query));
          }
        }
      }

      $result = \Drupal::getContainer()
        ->get('mongo.driver.set')
        ->bulkInsertFields($row);
    }

    Timer::stop($name);
    dpm(Timer::read($name) . 'ms');
  }

  /**
   * Test execute time to compare
   */
  public function runInsert2() {
    $win_fields = $this->getWinFields();
    $nids = $this->getNids();

    $name = 'time_one';
    Timer::start($name);

    $nodes = \Drupal::entityManager()->getStorage('node')->loadMultiple($nids);
    foreach ($nodes as $key => $node) {
      $row = array();

      foreach ($win_fields as $key => $field) {
        $row[$field] = \Drupal::getContainer()
          ->get('flexinfo.field.service')
          ->getFieldFirstValue($node, 'field_win_'. $field);
      }
    }

    Timer::stop($name);
    dpm(Timer::read($name) . 'ms -- 2');
  }

  /**
   *
     $query->fields('tablename', ['entity_id', 'field_win_ave_win_value']);
   */
  public function dbSelectFieldsValue($win_nid, $table = 'node__field_win_ave_win', $field_name = 'field_win_ave_win_value') {
    $query = \Drupal::database()->select($table, 'tablename');
    $query->fields('tablename', [$field_name]);
    $query->condition('tablename.entity_id', $win_nid);

    $output = $query->execute()->fetchCol();
    // $output = $query->countQuery()->execute()->fetchField();

    return $output;
  }

}
