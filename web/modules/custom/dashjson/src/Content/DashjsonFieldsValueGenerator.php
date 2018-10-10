<?php

/**
 * @file
 */
namespace Drupal\dashjson\Content;


/**
 * An example controller.
 */
class DashjsonFieldsValueGenerator {

  /**
   * dashjson/game/dataset?ave_win=2.76&diff_win=0.2&tags=英冠
   */
  public function gameFieldsValue() {
    $output = '';

    $node_fields = array(
      array(
        'type' => 'value',
        'field' => 'field_win_ave_win'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_ave_draw'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_ave_loss'
      ),
    );

    $win_nodes = \Drupal::getContainer()
      ->get('baseinfo.querynode.service')
      ->queryWinNodesByUrlRequest();


    foreach ($win_nodes as $key => $win_node) {

      $game_data = [];
      foreach ($node_fields as $key => $subrow) {
        $index = str_replace("field_win_", "", $subrow['field']);

        if ($subrow['type'] == 'term') {
          $game_data[$index] = \Drupal::getContainer()
            ->get('flexinfo.field.service')
            ->getFieldFirstTargetIdTermName($win_node, $subrow['field']);
        }
        else {
          $game_data[$index] = \Drupal::getContainer()
            ->get('flexinfo.field.service')
            ->getFieldFirstValue($win_node, $subrow['field']);
        }
      }

      $output[] = $game_data;
    }

    return $output;
  }

  /**
   * dashjson/game/dataset?ave_win=2.76&diff_win=0.2&tags=英冠
   */
  public function gameFieldsValue2() {
    $output = '';

    $node_fields = array(
      array(
        'type' => 'value',
        'field' => 'field_win_ave_win'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_ave_draw'
      ),
      array(
        'type' => 'value',
        'field' => 'field_win_ave_loss'
      ),
    );

    // $win_nids = \Drupal::getContainer()
    //   ->get('baseinfo.querynode.service')
    //   ->queryWinNidsByCondition(
    //     $ave_win = NULL,
    //     $ave_draw = NULL,
    //     $ave_loss = NULL,
    //     $diff_win = NULL,
    //     $diff_draw = NULL,
    //     $diff_loss = NULL,
    //     $tags = array()
    //   );

    $win_nids = array(35, 36, 37);

    $game_data = array();

    $output['ave_win'] = $game_data;
    $output['ave_draw'] = $game_data;
    $output['ave_loss'] = $game_data;

    return $output;
  }

  /**
   * dashjson/game/dataset?ave_win=2.76&diff_win=0.2&tags=英冠
   */
  public function gameFieldsValue2($win_nids) {
    $query = \Drupal::database()->select('node__field_win_ave_win', 'y1');
    $query->condition('y1.entity_id', $win_nids, 'IN');
    // $query->range(0, 1);

    $yamlform_id = $query->execute()->fetchField();

    return $yamlform_id;
  }

}
