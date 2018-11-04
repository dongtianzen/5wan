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

use Drupal\mongo\MongoDriverSet;


/**
 *
 */
class ManageContent {

  public function runInsert() {
    $win_nids = array(35);
    dpm($win_nids);

    $query = $this->dbSelectFieldsValue(
      $win_nids,
      'node__field_win_ave_win',
      'field_win_ave_win_value'
    );


    $output['ave_win'] = current($query);
    dpm($output);

    $Manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $MongoDriverSet = new MongoDriverSet($Manager);

    $bulk = new MongoDB\Driver\BulkWrite;
    $MongoDriverSet->runInsertFields($output, $bulk);

    // $output = \Drupal::getContainer()
    //   ->get('mongo.driver.set')
    //   ->runInsertFields($output);
  }

  /**
   *
     $query->fields('tablename', ['entity_id', 'field_win_ave_win_value']);
   */
  public function dbSelectFieldsValue($win_nids, $table = 'node__field_win_ave_win', $field_name = 'field_win_ave_win_value') {
    $query = \Drupal::database()->select($table, 'tablename');
    $query->fields('tablename', [$field_name]);
    $query->condition('tablename.entity_id', $win_nids, 'IN');
    // $query->range(0, 200);

    $output = $query->execute()->fetchCol();
    // $output = $query->countQuery()->execute()->fetchField();

    return $output;
  }




}
