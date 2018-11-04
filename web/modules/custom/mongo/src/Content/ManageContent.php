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

/**
 *
 */
class ManageContent {

  public function getNids() {
    $query = \Drupal::entityQuery('node');

    $query->condition('status', 1);
    $query->condition('type', 'win');
    $query->range(10, 3);

    $result = $query->execute();

    return array_values($result);
  }

  /**
   *
   */
  public function runInsert() {
    $nids = $this->getNids();

    foreach ($nids as $key => $nid) {
      $query = $this->dbSelectFieldsValue(
        $nid,
        'node__field_win_ave_win',
        'field_win_ave_win_value'
      );

      $row['ave_win'] = current($query);

      $output[] = $row;
    }

    dpm($output);

    // // sudo composer require mongodb/mongodb
    $result = \Drupal::getContainer()
      ->get('mongo.driver.set')
      ->runInsertFields($output);
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
