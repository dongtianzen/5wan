<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/debug/field_debug.php');
  _run_batch_entity_create_fields();
 */

use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;

function _run_batch_entity_create_fields() {
  $entity_info = array(
    'entity_type' => 'node',  // 'node', 'taxonomy_term', 'user'
    'bundle' => 'win',
  );

  $fields = _entity_fields_info();
  foreach ($fields as $field) {
    _entity_create_fields_save($entity_info, $field);
  }
}

/**
 *
  field type list:
    boolean
    datetime
    decimal
    email
    entity_reference
    file
    float
    image
    integer
    link
    list_integer
    list_string
    telephone
    string         // Text (plain)
    string_long    // Text (plain, long)
    text_long      // Text (formatted, long)
    text_with_summary
 */
function _entity_fields_info() {
  /** field sample */
  // $fields[] = array(
  //   'field_name' => 'field_day_close',
  //   'type'       => 'float',
  //   'label'      => t('Close'),
  // );

  /**
   * array sample
   */
  // $json_content_piece = array(
  //   "ini_win" => 1.51,
  //   "ini_draw" => 4.03,
  //   "ini_loss" => 6.95,
  // );

  foreach ($json_content_piece as $key => $value) {
    $fields[] = array(
      'field_name' => 'field_win_' . $key,
      'type'       => 'float',
      'label'      => t(ucfirst($key)),
    );
  }

  return $fields;
}

function _entity_create_fields_save($entity_info, $field) {
  $field_storage = FieldStorageConfig::create(array(
    'field_name'  => $field['field_name'],
    'entity_type' => $entity_info['entity_type'],
    'type'  => $field['type'],
    'settings' => array(
      'target_type' => 'node',
    ),
  ));
  $field_storage->save();

  $field_config = FieldConfig::create([
    'field_name'  => $field['field_name'],
    'label'       => $field['label'],
    'entity_type' => $entity_info['entity_type'],
    'bundle'      => $entity_info['bundle'],
  ]);
  $field_config->save();

  // manage form display
  entity_get_form_display($entity_info['entity_type'], $entity_info['bundle'], 'default')
    ->setComponent($field['field_name'], [
      'settings' => [
        'display' => TRUE,
      ],
    ])
    ->save();

  // manage display
  entity_get_display($entity_info['entity_type'], $entity_info['bundle'], 'default')
    ->setComponent($field['field_name'], [
      'settings' => [
        'display_summary' => TRUE,
      ],
    ])
    ->save();
}

/**
 *
 require_once(DRUPAL_ROOT . '/modules/custom/debug/field_debug.php');
 _entity_update_fields_value();
 */
function _entity_update_fields_value() {
  return;
  $old_value = 380;
  $new_value = 373;

  $old_values = range(380, 395);

  foreach ($old_values as $old_value) {
    $entitys = \Drupal::getContainer()
      ->get('flexinfo.querynode.service')
      ->nodesByStandardByFieldValue('win', $field_name = 'field_win_tags', $field_value = $old_value);

    foreach ($entitys as $key => $entity) {
      \Drupal::getContainer()
        ->get('flexinfo.field.service')
        ->updateFieldValue('node', $entity, 'field_win_tags', $new_value);
    }

    $entitys = \Drupal::getContainer()
      ->get('flexinfo.querynode.service')
      ->nodesByStandardByFieldValue('win', $field_name = 'field_win_tags', $field_value = $old_value);

    if (count($entitys) == 0) {
      $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($old_value);
      if ($term) {
        $term->delete();
        dpm('delete term - ' . $old_value);
      }
    }

    usleep(150000);
  }

}
