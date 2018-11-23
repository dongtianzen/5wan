<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/mongo//src/Content/ManageContent.php');

  $ManageContent = new ManageContent();
  $ManageContent->runInsert();

  mongodump -h 127.0.0.1:27017 -d 5wan -o /Applications/MAMP/htdocs/yourfolder/
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
   * save shorter field name
   */
  public function getWinFields() {
    $output = array(
      "num" => "num_company",
      "outlier" => "outlier",
      "ew" => "ave_win",     // end
      "ed" => "ave_draw",
      "el" => "ave_loss",
      "iw" => "ini_win",     // ini
      "id" => "ini_draw",
      "il" => "ini_loss",
      "vew" => "variation_end_win",     // variation_end
      "ved" => "variation_end_draw",
      "vel" => "variation_end_loss",
      "viw" => "variation_ini_win",
      "vid" => "variation_ini_draw",
      "vil" => "variation_ini_loss",
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
    $query->range(400000, 100000);      // from 10, total 10

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
   * Test load Nodes to execute time to compare
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

  /**
   *
   require_once(DRUPAL_ROOT . '/modules/custom/mongo//src/Content/ManageContent.php');

   $ManageContent = new ManageContent();
   $cc = $ManageContent->runFindUpdateOne();
   dpm($cc);

   {
    "_id" : ObjectId("5bf43edb931c0924332738fc"),
    "game_id" : 35,
    "ew" : 2.68,
    "ed" : 3.13,
    "el" : 2.62,
    "iw" : 2.74,
    "id" : 3.2,
    "il" : 2.47
   }
   */
  public function runFindUpdateOne() {
    $result = \Drupal::getContainer()
      ->get('mongo.driver.set')
      ->bulkFindUpdateOne2();
  }

}
