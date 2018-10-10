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
      ->queryWinNodesByCondition();


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

    $win_nids = \Drupal::getContainer()
      ->get('baseinfo.querynode.service')
      ->queryWinNidsByCondition();

    $output['ave_win'] = $game_data;
    $output['ave_draw'] = $game_data;
    $output['ave_loss'] = $game_data;

    return $output;
  }

}
