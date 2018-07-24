<?php

/**
 * @file
 */
namespace Drupal\dashpage\Content;

use Drupal\Core\Controller\ControllerBase;

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
  public function standardTrendPage($section) {
    $output = '';
    $output .= '<div class="row margin-0">';
      $output .= '<div id="standard-google-map-wrapper">';
        $output .= '<div id="map-canvas">';
          $output .= 'Trend Table';
          $output .= '<br />';
          $output .= $this->getTrendContent($section);
        $output .= '</div>';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   *
   */
  public function getTrendContent($section) {
    $output = '';
    $output .= '<table class="table table-striped">';
      $output .= '<thead>';
        $output .= '<tr>';
          $output .= $this->getTrendContentTheadRow($section);
        $output .= '</tr>';
      $output .= '</thead>';
      $output .= '<tbody>';
        $output .= $this->getTrendContentTbodyRow($section);
      $output .= '</tbody>';
    $output .= '</table>';

    return $output;
  }

  /**
   *
   */
  public function getTrendContentTheadRow($section) {
    $output = '';

    $variable = array(
      'Date',
      'Tags',
      'Home',
      'Away',
      'Win',
      'Draw',
      'Loss',
      'Goal',
      'Goal',
    );

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
  public function getTrendContentTbodyRow($section) {
    $output = '';

    $win_nids = $this->queryWinByCondition($ave_win = 2.03);
    dpm(count($win_nids));
    $win_nodes = \Drupal::entityManager()->getStorage('node')->loadMultiple($win_nids);

    foreach ($win_nodes as $key => $win_node) {
      $output .= '<tr>';
        $output .= '<td>';
          $output .= \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue($win_node, 'field_win_date_time');
        $output .= '</td>';
        $output .= '<td>';
          $output .= \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetIdTermName($win_node, 'field_win_tags');
        $output .= '</td>';
        $output .= '<td>';
          $output .= \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue($win_node, 'field_win_name_home');
        $output .= '</td>';
        $output .= '<td>';
          $output .= \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue($win_node, 'field_win_name_away');
        $output .= '</td>';
        $output .= '<td>';
          $output .= \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue($win_node, 'field_win_ave_win');
        $output .= '</td>';
        $output .= '<td>';
          $output .= \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue($win_node, 'field_win_ave_draw');
        $output .= '</td>';
        $output .= '<td>';
          $output .= \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue($win_node, 'field_win_ave_loss');
        $output .= '</td>';
        $output .= '<td>';
          $output .= \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue($win_node, 'field_win_goal_home');
        $output .= '</td>';
        $output .= '<td>';
          $output .= \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue($win_node, 'field_win_goal_away');
        $output .= '</td>';
      $output .= '</tr>';
    }

    return $output;
  }

  /**
   *
   */
  public function queryWinByCondition($ave_win = 2.03, $ave_draw = NULL, $ave_loss = NULL, $date = NULL) {
    $query_container = \Drupal::getContainer()->get('flexinfo.querynode.service');
    $query = $query_container->queryNidsByBundle('win');

    $ave_win_diff = 0.001;
    if ($ave_win) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_win', $ave_win - $ave_win_diff, '>');
      $query->condition($group);

      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_win', $ave_win + $ave_win_diff, '<');
      $query->condition($group);
    }
    if ($ave_draw) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_win', $ave_draw);
      $query->condition($group);
    }
    if ($ave_loss) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_win', $ave_loss);
      $query->condition($group);
    }

    // $query->sort('field_win_date', 'DESC');
    // $query->range(0, 2);
    $nids = $query_container->runQueryWithGroup($query);


    return $nids;
  }

  /**
   *
   */
  public function queryWinByCompareTime($ave_win = NULL, $ave_draw = NULL, $ave_loss = NULL, $date = NULL) {
    $query = \Drupal::service('entity.query');

    $query = $query->get('node')
    ->condition('type', 'win')
    ->condition('status', 1)
    ->condition('field_win_ave_win', 2.03, '>');

    $nids = $query->execute();

    return $nids;
  }

}
