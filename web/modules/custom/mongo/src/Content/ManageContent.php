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
class ManageDrupalContent {

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

/**
 *
 */
class ManageContent extends ManageDrupalContent {

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
    $query->range(0, 50000);      // from 10, total 10

    $result = $query->execute();

    return array_values($result);
  }

  /**
   *
   require_once(DRUPAL_ROOT . '/modules/custom/mongo//src/Content/ManageContent.php');

   $ManageContent = new ManageContent();
   $ManageContent->runCheckDuplication();
   */
  public function runCheckDuplication() {
    $game_ids = range(430398, 430399);
    $game_ids = range(84054, 84055);

    foreach ($game_ids as $key => $game_id) {
      $result = \Drupal::getContainer()
        ->get('mongo.driver.set')
        ->commandSet()
        ->runDatabaseStats($game_id);
    }

  }

  /**
   *
   */
  public function runUpdateInc() {
    $nids = $this->getNids();
    $nids = array(430398, 391207);

    foreach ($nids as $key => $nid) {
      $sql_query = $this->dbSelectFieldsValue(
        $nid,
        'node__field_win_id_500',
        'field_win_id_500_value'
      );

      $query = ['game_id' => intval($nid)];
      $inc_array = [
        'id5' => intval(current($sql_query))
      ];

      $result = \Drupal::getContainer()
        ->get('mongo.driver.set')
        ->bulkFindUpdateInc($query, $inc_array);
    }
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
        ->bulkFindUpdateSet($query, $update_set);
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
   require_once(DRUPAL_ROOT . '/modules/custom/mongo//src/Content/ManageContent.php');

   $ManageContent = new ManageContent();
   $cc = $ManageContent->runFindAndUpdateValue();
   */
  public function runFindAndUpdateValue($search_500_id = 167832) {
    $filter = ['id5' => $search_500_id];
    $rows = \Drupal::getContainer()
      ->get('mongo.driver.set')
      ->querySet()
      ->runExecuteQuery($filter);

    $nids = [];
    foreach ($rows as $document) {
      $node = \Drupal::entityManager()->getStorage('node')->load($document->game_id);

      if ($node) {
        $node_500_id = \Drupal::getContainer()
          ->get('flexinfo.field.service')
          ->getFieldFirstValue($node, 'field_win_id_500');

        // only modify the wrong one(not match one)
        if ($node_500_id != $search_500_id) {
          dpm($node->id());

          $query = ['_id' => $document->_id];
          // dpm($document->_id->__toString());

          $modify_array = [
            'id5' => ""
          ];

          $result = \Drupal::getContainer()
            ->get('mongo.driver.set')
            ->bulkSet()
            ->bulkFindUpdateUnset($query, $modify_array);
        }
      }

      // dpm($document->_id->__toString());

      // ksm($document);
      // var_dump($document);
    }

  }

  /**
   *
   require_once(DRUPAL_ROOT . '/modules/custom/mongo//src/Content/ManageContent.php');

   $ManageContent = new ManageContent();
   $cc = $ManageContent->runFindAndUpdate500IdDatasets();
   */
  public function runFindAndUpdate500IdDatasets() {
    $sets = $this->get500IdDatasets();

    foreach ($sets as $key => $value) {
      $this->runFindAndUpdateValue($value);
    }

  }

  /**
   *
   */
  public function get500IdDatasets() {
    $output = [
      168550,
    ];

    return $output;
  }


}
