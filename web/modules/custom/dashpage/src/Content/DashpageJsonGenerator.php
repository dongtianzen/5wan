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
  public function getGameListJson() {
    $output['gridColumns'] = \Drupal::getContainer()
      ->get('dashpage.tablebasic.service')
      ->getTrendTableThead();
    $output['gridData'] = $this->getGameListTbody();

    return $output;
  }

  /**
   *
   */
  public function getGameChartJson() {
    $output['chartDataSetSourceOne'] = $this->getChartDataSetSource()['one'];
    $output['chartDataSetSourceTwo'] = $this->getChartDataSetSource()['two'];
    $output['chartDataSetSourceSix'] = $this->getChartDataSetSource()['six'];

    return $output;
  }

  /**
   *
   */
  public function getChartDataBasicColorSet() {
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
      [
        'label' => 'Test',
        'backgroundColor' => '#66ccff',
        'data' => [],
      ],
    ];

    return $output;
  }

  /**
   *
   */
  public function getCurrentGameValueOne() {
    $request_array = \Drupal::request()->query->all();
    $output = [
      'x' =>  $request_array['ave_draw'],
      'y' =>  $request_array['ave_loss'],
      'r' => 10,
    ];

    return $output;
  }

  /**
   *
   */
  public function getCurrentGameValueTwo() {
    $request_array = \Drupal::request()->query->all();
    $output = [
      'x' =>  $request_array['ave_draw'] / $request_array['ave_loss'],
      'y' =>  $request_array['ave_win'],
      'r' => 10,
    ];

    return $output;
  }

  /**
   *
   */
  public function getCurrentGameValueSix() {
    $request_array = \Drupal::request()->query->all();
    $output = [
      'x' => ($request_array['ave_win'] - $request_array['ini_win']) * 10,
      'y' => ($request_array['ave_loss'] - $request_array['ini_loss']) * 10,
      'r' => ($request_array['ave_draw'] - $request_array['ini_draw']) + 10,
    ];

    return $output;
  }

  /**
   *
   */
  public function getChartDataSetSource() {
    $node_fields = \Drupal::getContainer()
      ->get('dashpage.managefields.service')
      ->getNodeWinField();
    $win_nodes = \Drupal::getContainer()
      ->get('baseinfo.querynode.service')
      ->queryWinNodesByCondition();
    $table_heads = \Drupal::getContainer()
      ->get('dashpage.tablebasic.service')
      ->getTrendTableThead();

    $output['one'] = $this->getChartDataBasicColorSet();
    $output['two'] = $this->getChartDataBasicColorSet();
    $output['six'] = $this->getChartDataBasicColorSet();

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

      $r_value = $this->getGameRSzie($win_node, $tbody['Win'], $tbody['Draw'], $tbody['Loss']);

      $chart_one_data = [
        'x' => $tbody['Draw'],
        'y' => $tbody['Loss'],
        'r' => $r_value,
      ];

      $chart_two_data = [
        'x' => $tbody['Draw'] / $tbody['Loss'],
        'y' => $tbody['Win'] ,
        'r' => $r_value,
      ];

      $ini_win_value = \Drupal::getContainer()
        ->get('flexinfo.field.service')
        ->getFieldFirstValue($win_node, 'field_win_ini_win');
      $ini_draw_value = \Drupal::getContainer()
        ->get('flexinfo.field.service')
        ->getFieldFirstValue($win_node, 'field_win_ini_draw');
      $ini_loss_value = \Drupal::getContainer()
        ->get('flexinfo.field.service')
        ->getFieldFirstValue($win_node, 'field_win_ini_loss');
      $chart_six_data = [
        'x' => ($tbody['Win'] - $ini_win_value) * 10,
        'y' => ($tbody['Loss'] - $ini_loss_value) * 10,
        'r' => ($tbody['Draw'] - $ini_draw_value) + 10,
      ];

      if ($tbody['GoalH'] > $tbody['GoalA']) {
        $output_key = 0;
      }
      elseif ($tbody['GoalH'] == $tbody['GoalA']) {
        $output_key = 1;
      }
      else {
        $output_key = 2;
      }

      $output['one'][$output_key]['data'][] = $chart_one_data;
      $output['two'][$output_key]['data'][] = $chart_two_data;
      $output['six'][$output_key]['data'][] = $chart_six_data;
    }

    $output['one'][3]['data'][] = $this->getCurrentGameValueOne();
    $output['two'][3]['data'][] = $this->getCurrentGameValueTwo();
    $output['six'][3]['data'][] = $this->getCurrentGameValueSix();

    return $output;
  }

  /**
   * @return $r_size is 10 - standard size
   */
  public function getGameRSzie($win_node, $ave_win_value = NULL, $ave_draw_value =NULL, $ave_loss_value = NULL) {
    $game_value_array = array($ave_win_value, $ave_draw_value, $ave_loss_value);
    $min_num_index = array_search(min($game_value_array), $game_value_array);

    if ($min_num_index == 0) {
      $ini_win_value = \Drupal::getContainer()
        ->get('flexinfo.field.service')
        ->getFieldFirstValue($win_node, 'field_win_ini_win');

      $r_size = $ave_win_value - $ini_win_value;
    }
    elseif ($min_num_index == 1) {
      $ini_draw_value = \Drupal::getContainer()
        ->get('flexinfo.field.service')
        ->getFieldFirstValue($win_node, 'field_win_ini_draw');

      $r_size = $ave_draw_value - $ini_draw_value;
    }
    elseif ($min_num_index == 2) {
      $ini_loss_value = \Drupal::getContainer()
        ->get('flexinfo.field.service')
        ->getFieldFirstValue($win_node, 'field_win_ini_loss');

      $r_size = $ave_loss_value - $ini_loss_value;
    }

    $r_size = $r_size * 20;
    $output = 10 + $r_size;

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

    $table_heads = \Drupal::getContainer()
      ->get('dashpage.tablebasic.service')
      ->getTrendTableThead();

    $node_fields = \Drupal::getContainer()
      ->get('dashpage.managefields.service')
      ->getNodeWinField();

    $win_nodes = \Drupal::getContainer()
      ->get('baseinfo.querynode.service')
      ->queryWinNodesByCondition();
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
