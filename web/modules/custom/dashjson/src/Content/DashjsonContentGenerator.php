<?php

/**
 * @file
 */
namespace Drupal\dashjson\Content;


/**
 * An example controller.
 */
class DashjsonContentGenerator {

  /**
   * dashjson/game/dataset?ave_win=2.76&diff_win=0.2&tags=英冠
   */
  public function getGameDataset() {
    $output = '';

    $node_fields = \Drupal::getContainer()
      ->get('dashpage.managefields.service')
      ->getNodeWinAllFields();

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

      if (isset($game_data['ave_win']) && isset($game_data['ini_win'])) {
        $game_data['diff_win'] = $game_data['ave_win'] - $game_data['ini_win'];
      }
      if (isset($game_data['ave_draw']) && isset($game_data['ini_draw'])) {
        $game_data['diff_draw'] = $game_data['ave_draw'] - $game_data['ini_draw'];
      }
      if (isset($game_data['ave_loss']) && isset($game_data['ini_loss'])) {
        $game_data['diff_loss'] = $game_data['ave_loss'] - $game_data['ini_loss'];
      }

      if ($game_data['goal_home'] > $game_data['goal_away']) {
        $game_data['Result'] = '3';
      }
      elseif ($game_data['goal_home'] == $game_data['goal_away']) {
        $game_data['Result'] = '1';
      }
      else {
        $game_data['Result'] = '0';
      }

      $output[] = $game_data;
    }

    return $output;
  }

}
