<?php

/**
 * @file
 */
namespace Drupal\dashpage\Content;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
 $DashpageJsonGenerator = new DashpageJsonGenerator();
 $DashpageJsonGenerator->demoPage();
 */
class DashpageJsonGenerator extends ControllerBase {

  /**
   *
   */
  public function getGameListJson() {
    $output['gridColumns'] = $this->getTrendTableThead();
    $output['gridData'] = $this->getGameListTbody();

    return $output;
  }


  /**
   *
   */
  public function getGameListTbody() {
    $output = '';

    $result = [
      'win' => 0,
      'draw' => 0,
      'loss' => 0,
    ];

    $table_heads = $this->getTrendTableThead();

    $node_fields = $this->getNodeWinField();

    $win_nodes = $this->queryWinNodesByCondition();
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
        $result['win']++;
        $tbody['Result'] = 3;
      }
      elseif ($tbody['GoalH'] == $tbody['GoalA']) {
        $result['draw']++;
        $tbody['Result'] = 1;
      }
      else {
        $result['loss']++;
        $tbody['Result'] = 0;
      }

      $output[] = $tbody;
    }

    return $output;
  }

}
