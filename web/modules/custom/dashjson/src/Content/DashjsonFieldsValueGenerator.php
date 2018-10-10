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
  public function gameFieldsValue1() {
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

    // $win_nids = \Drupal::getContainer()
    //   ->get('baseinfo.querynode.service')
    //   ->queryWinNidsByCondition(
    //     $ave_win = 2.05,
    //     $ave_draw = NULL,
    //     $ave_loss = NULL,
    //     $diff_win = 0.01,
    //     $diff_draw = NULL,
    //     $diff_loss = NULL,
    //     $tags = array()
    //   );

    $win_nids = array(35, 36, 37);

    $game_data = array();
dpm($this->dbSelectFieldsValue($win_nids));
    $output['ave_win'] = $this->dbSelectFieldsValue($win_nids);
    // $output['ave_win'] = array_value($this->dbSelectFieldsValue($win_nids));
    $output['ave_draw'] = $game_data;
    $output['ave_loss'] = $game_data;

    return $output;
  }

  /**
   * dashjson/game/dataset?ave_win=2.76&diff_win=0.2&tags=英冠
   */
  public function dbSelectFieldsValue($win_nids) {
    $query = \Drupal::database()->select('node__field_win_ave_win', 'y1');
    // $query->fields('y1', ['entity_id', 'field_win_ave_win_value']);
    $query->fields('y1', ['field_win_ave_win_value']);
    $query->condition('y1.entity_id', $win_nids, 'IN');
    $query->range(0, 30);


    $output = $query->execute()->fetchCol();

    // $output = $query->countQuery()->execute()->fetchField();

    return $output;
  }

}
