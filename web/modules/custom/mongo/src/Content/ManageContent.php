<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/mongo//src/Content/ManageContent.php');

  $ManageContent = new ManageContent();
  $ManageContent->runInsert();

  mongodump -h 127.0.0.1:27017 -d 5wan -o /Applications/MAMP/htdocs/yourfolder/

  mongorestore -h 127.0.0.1:27017 -d 5wan /Applications/MAMP/htdocs/yourfolder/5wan/game440071.bson
 */

/**
 * Execute a database query
 *
 * http://zetcode.com/db/mongodbphp/
 */

use Drupal\Component\Utility\Timer;

use Drupal\batchinfo\Content\SyncJsonToNode;

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
      "id" => "id_500",
      "outlier" => "outlier",
      "ew" => "ave_win",     // end
      "ed" => "ave_draw",
      "el" => "ave_loss",
      "sw" => "ini_win",     // start
      "sd" => "ini_draw",
      "sl" => "ini_loss",
      "vew" => "variation_end_win",     // variation_end
      "ved" => "variation_end_draw",
      "vel" => "variation_end_loss",
      "vsw" => "variation_ini_win",     // variation start
      "vsd" => "variation_ini_draw",
      "vsl" => "variation_ini_loss",
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
  public function runUpdateInc() {
    $nids = $this->getNids();

    $name = 'time_one';
    Timer::start($name);

    foreach ($nids as $key => $nid) {
      $query = $this->dbSelectFieldsValue(
        $nid,
        'node__field_win_id_500',
        'field_win_id_500_value'
      );

      $result = \Drupal::getContainer()
        ->get('mongo.driver.set')
        ->bulkFindUpdateInc(intval($nid), intval(current($query)));
    }

    Timer::stop($name);
    dpm(Timer::read($name) . 'ms');
  }

  /**
   *
   "name_away": "莫纳加斯",
   "name_home": "FC波图格萨",
   "num_company": 111,
   "variation_end_draw": "5.63",
   "variation_end_loss": "31.16",
   "variation_end_win": "4.75",
   "variation_ini_draw": "8.84",
   "variation_ini_loss": "24.48",
   "variation_ini_win": "3.39"

   require_once(DRUPAL_ROOT . '/modules/custom/mongo//src/Content/ManageContent.php');

   $ManageContent = new ManageContent();
   $ManageContent->runUpdateFromJson();
   */
  public function runUpdateFromJson() {
    $SyncJsonToNode = new SyncJsonToNode();
    $json_content = $SyncJsonToNode->getImportJsonContent();

    $name = 'time_one';
    Timer::start($name);

    foreach ($json_content as $key => $row) {
      $query = [
        'id5' => intval($key)
      ];

      $update_set = [
        "vew" => floatval($row["variation_end_win"]),
        "ved" => floatval($row["variation_end_draw"]),
        "vel" => floatval($row["variation_end_loss"]),
        "vsw" => floatval($row["variation_ini_win"]),
        "vsd" => floatval($row["variation_ini_draw"]),
        "vsl" => floatval($row["variation_ini_loss"]),
      ];

      $result = \Drupal::getContainer()
        ->get('mongo.driver.set')
        ->bulkFindUpdateSetFromJson($query, $update_set);
    }

    Timer::stop($name);
    dpm(Timer::read($name) . 'ms');
  }

  /**
   *
   */
  public function runInsert() {
    $win_fields = $this->getWinFields();
    // $nids = $this->getNids();

    $name = 'time_one';
    Timer::start($name);

    foreach ($nids as $key => $nid) {
      $row = array();

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
      ->bulkFindUpdateSet();
  }

}
