<?php

/**
 * @file
 */
namespace Drupal\dashpage\Content;

use Drupal\Core\Controller\ControllerBase;

use Drupal\dashpage\Content\DashpageManageFields;

/**
 * An example controller.
 $DashpageContentGenerator = new DashpageContentGenerator();
 $DashpageContentGenerator->angularPage();
 */
class DashpageContentGenerator extends ControllerBase {

  public function __construct() {
  }

  /**
   *
   */
  public function standardTrendPage() {
    $output = '';
    $output .= '<div class="row margin-0">';
      $output .= '<div id="standard-google-map-wrapper">';
        $output .= '<div id="map-canvas">';
          $output .= 'Trend Table';
          $output .= '<br />';
          $output .= $this->getTrendPageTableContent();
        $output .= '</div>';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   *
   */
  public function getTrendPageTableContent() {
    $output = '';
    $output .= '<table class="table table-striped">';
      $output .= '<thead>';
        $output .= '<tr>';
          $output .= $this->getTrendPageTableThead();
        $output .= '</tr>';
      $output .= '</thead>';
      $output .= '<tbody>';
        $output .= $this->getTrendPageTableTbody();
      $output .= '</tbody>';
    $output .= '</table>';

    return $output;
  }

  /**
   *
   */
  public function getTrendPageTableThead() {
    $output = '';

    $variable = \Drupal::getContainer()->get('dashpage.tablebasic.service')->getTrendTableThead();

    foreach ($variable as $key => $value) {
      $output .= '<th>';
        $output .= $value;
      $output .= '</th>';
    }

    return $output;
  }

  /**
   *
   */
  public function getTrendPageTableTbody() {
    $tbody = '';

    $node_fields = \Drupal::getContainer()->get('dashpage.managefields.service')->getNodeWinField();

    $result = [
      'win' => 0,
      'draw' => 0,
      'loss' => 0,
    ];

    $win_nodes = \Drupal::getContainer()->get('baseinfo.querynode.service')->queryWinNodesByCondition();
    foreach ($win_nodes as $key => $win_node) {

      foreach ($node_fields as $row) {
        if ($row['type'] == 'term') {
          $temp[$row['field']] = \Drupal::getContainer()
            ->get('flexinfo.field.service')
            ->getFieldFirstTargetIdTermName($win_node, $row['field']);
        }
        else {
          $temp[$row['field']] = \Drupal::getContainer()
            ->get('flexinfo.field.service')
            ->getFieldFirstValue($win_node, $row['field']);
        }
      }

      if ($temp['field_win_goal_home'] > $temp['field_win_goal_away']) {
        $temp['field_win_ave_win'] = '<span class="color-blue">' . $temp['field_win_ave_win'] . '</span>';
        $result['win']++;
      }
      elseif ($temp['field_win_goal_home'] == $temp['field_win_goal_away']) {
        $temp['field_win_ave_draw'] = '<span class="color-blue">' . $temp['field_win_ave_draw'] . '</span>';
        $result['draw']++;
      }
      else {
        $temp['field_win_ave_loss'] = '<span class="color-blue">' . $temp['field_win_ave_loss'] . '</span>';
        $result['loss']++;
      }

      $tbody .= '<tr>';
        foreach ($temp as $value) {
          $tbody .= '<td>';
            $tbody .= $value;
          $tbody .= '</td>';
        }

      $tbody .= '</tr>';
    }

    dpm(count($win_nids));
    dpm($result);

    return $output;
  }

}
