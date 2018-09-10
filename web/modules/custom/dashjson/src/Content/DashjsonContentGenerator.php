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
   *
   */
  public function getGameDataset() {
    $output = $this->getGameListTbody();

    return $output;
  }

  /**
   *
   */
  public function getGameListTbody() {
    $output = '';

    $table_heads = \Drupal::getContainer()->get('dashpage.tablebasic.service')->getTrendTableThead();

    $node_fields = \Drupal::getContainer()->get('dashpage.managefields.service')->getNodeWinField();

    $win_nodes = \Drupal::getContainer()->get('baseinfo.querynode.service')->queryWinNodesByCondition();
    foreach ($win_nodes as $key => $win_node) {

      $tbody = [];
      foreach ($node_fields as $subkey => $subrow) {
        if ($subrow['type'] == 'term') {
          $tbody[$table_heads[$subkey]] = \Drupal::getContainer()
            ->get('flexinfo.field.service')
            ->getFieldFirstTargetIdTermName($win_node, $subrow['field']);
        }
        else {
          $tbody[$table_heads[$subkey]] = \Drupal::getContainer()
            ->get('flexinfo.field.service')
            ->getFieldFirstValue($win_node, $subrow['field']);
        }
      }

      if ($tbody['GoalH'] > $tbody['GoalA']) {
        $tbody['Result'] = '3';
      }
      elseif ($tbody['GoalH'] == $tbody['GoalA']) {
        $tbody['Result'] = '1';
      }
      else {
        $tbody['Result'] = '0';
      }

      $output[] = $tbody;
    }

    return $output;
  }

}
