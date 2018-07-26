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
  public function standardTrendPage() {
    $output = '';
    $output .= '<div class="row margin-0">';
      $output .= '<div id="standard-google-map-wrapper">';
        $output .= '<div id="map-canvas">';
          $output .= 'Trend Table';
          $output .= '<br />';
          $output .= $this->getTrendContent();
        $output .= '</div>';
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   *
   */
  public function getTrendContent() {
    $output = '';
    $output .= '<table class="table table-striped">';
      $output .= '<thead>';
        $output .= '<tr>';
          $output .= $this->getTrendContentTheadRow();
        $output .= '</tr>';
      $output .= '</thead>';
      $output .= '<tbody>';
        $output .= $this->getTrendContentTbodyRow();
      $output .= '</tbody>';
    $output .= '</table>';

    return $output;
  }

  /**
   *
   */
  public function getTrendContentTheadRow() {
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
  public function getTrendContentTbodyRow() {
    $output = '';

    $win_nids = $this->queryWinByCondition();
    dpm(count($win_nids));
    $win_nodes = \Drupal::entityManager()->getStorage('node')->loadMultiple($win_nids);

    $node_fields = [
      'field_win_name_home',
      'field_win_name_away',
      'field_win_ave_win',
      'field_win_ave_draw',
      'field_win_ave_loss',
      'field_win_goal_home',
      'field_win_goal_away',
      'field_win_num_company',
    ];

    foreach ($win_nodes as $key => $win_node) {
      $output .= '<tr>';
        $output .= '<td>';
          $output .= \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue($win_node, 'field_win_date_time');
        $output .= '</td>';
        $output .= '<td>';
          $output .= \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstTargetIdTermName($win_node, 'field_win_tags');
        $output .= '</td>';

        foreach ($node_fields as $key => $row) {
          $output .= '<td>';
            $output .= \Drupal::getContainer()->get('flexinfo.field.service')->getFieldFirstValue($win_node, $row);
          $output .= '</td>';
        }
      $output .= '</tr>';
    }

    return $output;
  }

  /**
   *
   */
  public function queryWinByCondition($ave_win = NULL, $ave_draw = NULL, $ave_loss = NULL, $ave_win_diff = NULL, $ave_draw_diff = NULL, $ave_loss_diff = NULL) {
    $request_array = \Drupal::request()->query->all();
    if (isset($request_array['ave_win'])) {
      $ave_win = $request_array['ave_win'];
    }
    if (isset($request_array['ave_draw'])) {
      $ave_draw = $request_array['ave_draw'];
    }
    if (isset($request_array['ave_loss'])) {
      $ave_loss = $request_array['ave_loss'];
    }

    if (!$ave_win_diff) {
      $ave_win_diff = 0.001;
    }
    if (!$ave_draw_diff) {
      $ave_draw_diff = 2;
    }
    if (!$ave_loss_diff) {
      $ave_loss_diff = 20;
    }

    $query_container = \Drupal::getContainer()->get('flexinfo.querynode.service');
    $query = $query_container->queryNidsByBundle('win');

    if ($ave_win) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_win', $ave_win - $ave_win_diff, '>');
      $query->condition($group);

      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_win', $ave_win + $ave_win_diff, '<');
      $query->condition($group);
    }

    if ($ave_draw) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_draw', $ave_draw - $ave_draw_diff, '>');
      $query->condition($group);

      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_draw', $ave_draw + $ave_draw_diff, '<');
      $query->condition($group);
    }

    if ($ave_loss) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_loss', $ave_loss - $ave_loss_diff, '>');
      $query->condition($group);

      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_loss', $ave_loss + $ave_loss_diff, '<');
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
    ->condition('type', 'page')
    ->condition('status', 1)
    ->condition('field_page_float_number', 2.01, '>')
    ->condition('field_page_float_number', 2.03, '<');
    $nids = $query->execute();

    return $nids;
  }

}
