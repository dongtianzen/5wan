<?php

/**
 * @file
 */
namespace Drupal\dashpage\Content;

use Drupal\Core\Controller\ControllerBase;

use Drupal\dashpage\Content\DashpageManageFields;

/**
 * An example controller.
 $DashpageJsonGenerator = new DashpageJsonGenerator();
 $DashpageJsonGenerator->demoPage();
 */
class DashpageJsonGenerator extends ControllerBase {

  /**
   *
   */
  public function getGameChartJson() {
    $output['chartDataSetSource'] = $this->getChartDataSetSource();
    $output['chartDataSetSourceTwo'] = $this->getChartDataSetSourceTwo();

    return $output;
  }

  /**
   *
   */
  public function getGameListJson() {
    $output['gridColumns'] = \Drupal::getContainer()->get('dashpage.tablebasic.service')->getTrendTableThead();
    $output['gridData'] = $this->getGameListTbody();

    return $output;
  }

  /**
   *
   */
  public function getChartDataSetSource() {
    $output = '';

    $output = [
      [
        'label' => 'win',
        'backgroundColor' => '#79f879',
        'data' => [],
      ],
      [
        'label' => 'Draw',
        'backgroundColor' => '#7979f8',
        'data' => [],
      ],
      [
        'label' => 'Loss',
        'backgroundColor' => '#f87979',
        'data' => [],
      ],
    ];

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

      $win_value_array = array($tbody['Win'], $tbody['Draw'], $tbody['Loss']);
      $min_num_index = array_search(min($win_value_array), $win_value_array);

      // 10 is standard size
      $r_size = 10;

      if ($min_num_index == 0) {
        $ini_win_value = \Drupal::getContainer()
          ->get('flexinfo.field.service')
          ->getFieldFirstValue($win_node, 'field_win_ini_win');
        $r_size = ($tbody['Win'] - $ini_win_value);
      }
      elseif ($min_num_index == 1) {
        $ini_draw_value = \Drupal::getContainer()
          ->get('flexinfo.field.service')
          ->getFieldFirstValue($win_node, 'field_win_ini_draw');
        $r_size = ($tbody['Draw'] - $ini_draw_value);
      }
      elseif ($min_num_index == 2) {
        $ini_loss_value = \Drupal::getContainer()
          ->get('flexinfo.field.service')
          ->getFieldFirstValue($win_node, 'field_win_ini_loss');
        $r_size = ($tbody['Loss'] - $ini_loss_value);
      }

      $r_size = $r_size * 20;
      $r_size = 10 + $r_size;

      $chart_data = [
        'x' => $tbody['Draw'],
        'y' => $tbody['Loss'],
        'r' => $r_size,
      ];

      if ($tbody['GoalH'] > $tbody['GoalA']) {
        $output[0]['data'][] = $chart_data;
      }
      elseif ($tbody['GoalH'] == $tbody['GoalA']) {
        $output[1]['data'][] = $chart_data;
      }
      else {
        $output[2]['data'][] = $chart_data;
      }

    }

    return $output;
  }

  /**
   *
   */
  public function getChartDataSetSourceTwo() {
    $output = '';

    $output = [
      [
        'label' => 'win',
        'backgroundColor' => '#4e3e9c',
        'data' => [],
      ],
      [
        'label' => 'Draw',
        'backgroundColor' => '#8c9c3e',
        'data' => [],
      ],
      [
        'label' => 'Loss',
        'backgroundColor' => '#9c463e',
        'data' => [],
      ],
    ];

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

      $win_value_array = array($tbody['Win'], $tbody['Draw'], $tbody['Loss']);
      $min_num_index = array_search(min($win_value_array), $win_value_array);

      // 10 is standard size
      $r_size = 10;

      if ($min_num_index == 0) {
        $ini_win_value = \Drupal::getContainer()
          ->get('flexinfo.field.service')
          ->getFieldFirstValue($win_node, 'field_win_ini_win');
        $r_size = ($tbody['Win'] - $ini_win_value);
      }
      elseif ($min_num_index == 1) {
        $ini_draw_value = \Drupal::getContainer()
          ->get('flexinfo.field.service')
          ->getFieldFirstValue($win_node, 'field_win_ini_draw');
        $r_size = ($tbody['Draw'] - $ini_draw_value);
      }
      elseif ($min_num_index == 2) {
        $ini_loss_value = \Drupal::getContainer()
          ->get('flexinfo.field.service')
          ->getFieldFirstValue($win_node, 'field_win_ini_loss');
        $r_size = ($tbody['Loss'] - $ini_loss_value);
      }

      $r_size = $r_size * 20;
      $r_size = 10 + $r_size;

      $chart_data = [
        'x' => $tbody['Draw'],
        'y' => $tbody['Loss'],
        'r' => $r_size,
      ];

      if ($tbody['GoalH'] > $tbody['GoalA']) {
        $output[0]['data'][] = $chart_data;
      }
      elseif ($tbody['GoalH'] == $tbody['GoalA']) {
        $output[1]['data'][] = $chart_data;
      }
      else {
        $output[2]['data'][] = $chart_data;
      }

    }

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
        $result['win']++;
        $tbody['Result'] = '3';
      }
      elseif ($tbody['GoalH'] == $tbody['GoalA']) {
        $result['draw']++;
        $tbody['Result'] = '1';
      }
      else {
        $result['loss']++;
        $tbody['Result'] = '0';
      }

      $output[] = $tbody;
    }

    return $output;
  }

}
