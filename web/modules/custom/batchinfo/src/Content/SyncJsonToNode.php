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
  public function runBatchinfoCreateNodeEntity($game_id, $json_content_piece = NULL) {
    if (TRUE) {

      // skip some game 有基本比赛信息，但是没有赔率信息
      if ($json_content_piece['ave_win']) {
        $node_nids = $this->queryNodeToCheckExistByField($game_id, $json_content_piece);

        if (count($node_nids) > 0) {
          drupal_set_message('Game ' . $game_id . ' have - ' . count($node_nids) . ' - same item', 'error');
          return;
        }
        else {
          $this->runCreateNodeEntity($game_id, $json_content_piece);
        }
      }
    }

    //sleep for 0.2 seconds
    usleep(150000);

    return;
  }

  /**
   *
   * @param, @key is code and date
   */
  public function runBatchinfoUpdateNodeEntity($game_id, $json_content_piece = NULL) {
    if (TRUE) {

      // skip some game 有基本比赛信息，但是没有赔率信息
      if ($json_content_piece['ave_win']) {
        $node_nids = $this->queryNodeToCheckExistByField($game_id, $json_content_piece);

        if (count($node_nids) > 0) {
          drupal_set_message('Game ' . $game_id . ' have - ' . count($node_nids) . ' - same item', 'error');
          return;
        }
        else {
          $this->runCreateNodeEntity($game_id, $json_content_piece);
        }
      }
    }

    //sleep for 0.2 seconds
    usleep(150000);

    return;
  }

  /**
   *
   */
  public function runCreateNodeEntity($game_id, $json_content_piece = NULL) {
    $fields_value = $this->generateNodefieldsValue($game_id, $json_content_piece);

    \Drupal::getContainer()->get('flexinfo.node.service')->entityCreateNode($fields_value);

    return;
  }

  /**
   *
   */
  public function generateNodefieldsValue($game_id, $json_content_piece = NULL) {
    $entity_bundle = 'win';
    $language = \Drupal::languageManager()->getCurrentLanguage()->getId();

    $fields_value = array(
      'type' => $entity_bundle,
      'title' =>  $entity_bundle . ' From JSON ' . $game_id . ' - ' . $json_content_piece['date_time'],
      'langcode' => $language,
      'uid' => 1,
      'status' => 1,
    );

    // special fix value
    $tags_tid = $this->getTidByTermNameIfNullCreatNew($json_content_piece['tags'], $vocabulary_name = 'tags', $create_new = TRUE);

    $fields_value['field_win_id_500'] = array(
      $game_id,
    );

    $fields_value['field_win_tags'] = array(
      'target_id' => $tags_tid,  // term tid
    );

    $node_bundle_fields = $this->allNodeBundleFields($json_content_piece);
    foreach ($node_bundle_fields as $row) {
      // skip speical field
      if ($row['field_name'] == 'field_win_tags') {
        continue;
      }

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
  public function getTidByTermNameIfNullCreatNew($term_name = NULL, $vocabulary_name = NULL, $create_new = FALSE) {
    // special fix value
    $tid = \Drupal::getContainer()
      ->get('flexinfo.term.service')
      ->getTidByTermName($term_name, $vocabulary_name);

    if (!$tid) {
      if ($term_name && $vocabulary_name) {
        if ($create_new) {
          $tid = \Drupal::getContainer()->get('flexinfo.term.service')->entityCreateTerm($term_name, $vocabulary_name);
        }
      }
    }

    return $tid;
  }


  public function queryNodeToCheckExistByField($game_id, $json_content_piece = NULL) {
    $query_container = \Drupal::getContainer()->get('flexinfo.querynode.service');
    $query = $query_container->queryNidsByBundle('win');

    if (isset($game_id)) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_id_500', $game_id);
      $query->condition($group);
    }

    if (isset($json_content_piece['date_time'])) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_date_time', $json_content_piece['date_time']);
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
      "date_time" => "2016-02-20T17:00",
      "goal_away" => "1",
      "goal_home" => "1",
      "ini_draw" => "3.20",
      "ini_loss" => "2.47",
      "ini_win" => "2.74",
      "name_away" => "女王公园巡游者",
      "name_home" => "博尔顿",
      "tags" => "英冠",
      "num_company" => "50",
      "variation_end_draw" => "10.2",
      "variation_end_loss" => "10.2",
      "variation_end_win" => "10.2",
      "variation_ini_draw" => "10.2",
      "variation_ini_loss" => "10.2",
      "variation_ini_win" => "10.2"
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
