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
    $fenbu = $this->getFenbuArray();

    $output = '';
    $output .= '<table class="table table-striped">';
      $output .= '<thead>';
        $output .= '<tr>';
          $output .= '<th>';
            $output .= 'Date';
          $output .= '</th>';
          $output .= '<th>';
            $output .= 'Tags';
          $output .= '</th>';
          $output .= '<th>';
            $output .= 'Ave';
          $output .= '</th>';
          $output .= '<th>';
            $output .= 'Goal';
          $output .= '</th>';
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
  public function getTrendContentTbodyRow($section) {
    $output = '';

    $win_nids = $this->queryWinByCondition($code_tid = NULL, $query_date);
    $win_nodes = \Drupal::entityManager()->getStorage('node')->loadMultiple($win_nids);

    foreach ($win_nodes as $key => $win_node) {
      $output .= '<tr>';
        $output .= '<td>';
          $output .= 88;
        $output .= '</td>';
        $output .= '<td>';
          $output .= 77 . '%';
        $output .= '</td>';
        $output .= '<td>';
          $output .= 66;
        $output .= '</td>';
      $output .= '</tr>';
    }

    return $output;
  }

  /**
   *
   */
  public function getFenbuArray() {
    $output = [
      'p9>' => 0,
      'p5>' => 0,
      'p0>' => 0,
      'p0<' => 0,
      'p5<' => 0,
      'p9<' => 0,
      'else' => 0,
    ];

    return $output;
  }

  /**
   *
   */
  public function queryWinByCondition($ave_win = NULL, $ave_draw = NULL, $ave_loss = NULL, $date = NULL) {
    $query_container = \Drupal::getContainer()->get('flexinfo.querynode.service');
    $query = $query_container->queryNidsByBundle('win');

    if ($ave_win) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_win', $ave_win);
      $query->condition($group);
    }

    if ($date) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_date', $date);
      $query->condition($group);
    }

    // $query->sort('field_win_date', 'DESC');
    // $query->range(0, 2);
    $nids = $query_container->runQueryWithGroup($query);

    return $nids;
  }

}
