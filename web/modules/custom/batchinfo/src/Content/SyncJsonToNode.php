<?php

/**
 * @file
 * Contains \Drupal\batchinfo\Content\SyncJsonToNode.
 */

/**
 * An example controller.
   $SyncJsonToNode = new SyncJsonToNode();
   $SyncJsonToNode->_run_create_meeting_from_json();
 */

namespace Drupal\batchinfo\Content;

use Symfony\Component\HttpFoundation\JsonResponse;

class SyncJsonToNode {

  public $json_filename;
  public $json_file_path;

  /**
   *
   */
  public function __construct() {
    $this->json_filename = 'downloadGameInfo.json';

    $this->json_file_path = '/sites/default/files/json/5wan/' . $this->json_filename;
  }

  /**
   *
   */
  public function getImportJsonContent() {
    $output = $this->getSingleJsonContent();

    drupal_set_message('Total have - ' . count($output) . ' - records');

    return $output;
  }

  /**
   *
   */
  public function getSingleJsonContent() {
    $output = \Drupal::getContainer()
      ->get('flexinfo.json.service')
      ->fetchConvertJsonToArrayFromInternalPath($this->json_file_path);

    return $output;
  }

  /**
   *
   * @param, @key is code and date
   */
  public function runBatchinfoCreateNodeEntity($key, $json_content_piece = NULL) {
    dpm($key);
    dpm($json_content_piece);
    if (TRUE) {
      $node_nids = $this->queryNodeToCheckExistByField(NULL, $json_content_piece);

      if (count($node_nids) > 0) {
        drupal_set_message('Node have - ' . count($node_nids) . ' - same item', 'error');
        return;
      }
      else {
        // $this->runCreateNodeEntity($code, $date, $json_content_piece);
      }
    }

    sleep(0.01);

    return;
  }

  /**
   *
   */
  public function runCreateNodeEntity($code, $date, $json_content_piece = NULL) {
    $fields_value = $this->generateNodefieldsValue($code, $date, $json_content_piece);

    \Drupal::getContainer()->get('flexinfo.node.service')->entityCreateNode($fields_value);

    return;
  }

  /**
   *
   */
  public function generateNodefieldsValue($code, $date, $json_content_piece = NULL) {
    $entity_bundle = 'win';
    $language = \Drupal::languageManager()->getCurrentLanguage()->getId();

    $fields_value = array(
      'type' => $entity_bundle,
      'title' =>  $entity_bundle . ' From JSON ' . $code . ' - ' . $date,
      'langcode' => $language,
      'uid' => 1,
      'status' => 1,
    );

    // special fix value
    $code_tid = \Drupal::getContainer()
      ->get('flexinfo.term.service')
      ->getTidByTermName($code, $vocabulary_name = 'code');

    $fields_value['field_day_code'] = array(
      'target_id' => $code_tid,  // term tid
    );

    $fields_value['field_day_date'] = array(
      $date,
    );

    $node_bundle_fields = $this->allNodeBundleFields($json_content_piece);
    foreach ($node_bundle_fields as $row) {
      if (isset($row['vocabulary'])) {

      }
      elseif (isset($row['userRole'])) {

      }
      else {
        $fields_value[$row['field_name']] = $json_content_piece[$row['json_key']];
      }
    }

    return $fields_value;
  }

  /**
   *
   */
  public function queryNodeToCheckExistByField($id, $json_content_piece = NULL) {
    $query_container = \Drupal::getContainer()->get('flexinfo.querynode.service');
    $query = $query_container->queryNidsByBundle('day');

    if (isset($id)) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_id_500', $id);
      $query->condition($group);
    }

    if (isset($json_content_piece['date'])) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_date', $json_content_piece['date']);
      $query->condition($group);
    }

    if (isset($json_content_piece['ave_win'])) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_win', $json_content_piece['ave_win']);
      $query->condition($group);
    }

    $nids = $query_container->runQueryWithGroup($query);

    return $nids;
  }

  /**
   *
   */
  public function allNodeBundleFields($json_content_piece = array()) {
    /** user sample */
    // $node_bundle_fields[] = array(
    //   'field_name' => 'field_meeting_speaker',
    //   'userRole' => 'speaker',
    // );

    /** term sample */
    // $node_bundle_fields[] = array(
    //   'field_name' => 'field_day_code',
    //   'vocabulary' => 'code',
    // );

    /** value sample */
    // $node_bundle_fields[] = array(
    //   'field_name' => 'field_day_open',
    //   'json_key' => 'open',
    // );

    $json_content_piece = array(
      "ave_draw" => "3.13",
      "ave_loss" => "2.62",
      "ave_win" => "2.68",
      "date" => "2016-02-20",
      "goal_away" => "1",
      "goal_home" => "1",
      "ini_draw" => "3.20",
      "ini_loss" => "2.47",
      "ini_win" => "2.74",
      "name_away" => "女王公园巡游者",
      "name_home" => "博尔顿",
      "tag" => "英冠"
    );

    foreach ($json_content_piece as $key => $value) {
      $node_bundle_fields[] = array(
        'field_name' => 'field_win_' . $key,
        'json_key' => $key,
      );
    }

    return $node_bundle_fields;
  }

}
