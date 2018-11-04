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

  /**
   *
   */
  public function getWinFields() {
    $output = array(
      "ave_win",
      "ave_draw",
      "ave_loss",
      "ini_win",
      "ini_draw",
      "ini_loss",
      "variation_end_win",
      "variation_end_draw",
      "variation_end_loss",
      "variation_ini_win",
      "variation_ini_draw",
      "variation_ini_loss",
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
    $query->range(10, 3);

    $result = $query->execute();

    return array_values($result);
  }

  /**
   *
   */
  public function runInsert() {
    $win_fields = $this->getWinFields();
    $nids = $this->getNids();

    foreach ($nids as $key => $nid) {
      $row = array();
      foreach ($win_fields as $key => $field) {
        $query = $this->dbSelectFieldsValue(
          $nid,
          'node__field_win_' . $field,
          'field_win_' . $field . '_value'
        );

        $row[$field] = current($query);
      }

      $result = \Drupal::getContainer()
        ->get('mongo.driver.set')
        ->runInsertFields($row);

      dpm($result);
    }

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
