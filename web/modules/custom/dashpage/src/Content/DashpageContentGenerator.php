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

    $variable = $this->getTrendTableThead();

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

    $node_fields = $this->getNodeWinField();

    $result = [
      'win' => 0,
      'draw' => 0,
      'loss' => 0,
    ];

    $win_nodes = $this->queryWinNodesByCondition();
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

    $tbody;

    return $output;
  }

  /**
   *
   */
  public function queryWinNidsByCondition($ave_win = NULL, $ave_draw = NULL, $ave_loss = NULL, $diff_win = NULL, $diff_draw = NULL, $diff_loss = NULL, $tags = NULL) {
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

    //
    if (isset($request_array['diff_win'])) {
      $diff_win = $request_array['diff_win'];
    }
    if (isset($request_array['diff_draw'])) {
      $diff_draw = $request_array['diff_draw'];
    }
    if (isset($request_array['diff_loss'])) {
      $diff_loss = $request_array['diff_loss'];
    }

    if (!$diff_win) {
      $diff_win = 0.001;
    }
    if (!$diff_draw) {
      $diff_draw = 2;
    }
    if (!$diff_loss) {
      $diff_loss = 20;
    }

    //
    if (isset($request_array['tags'])) {
      $tags = $request_array['tags'];
    }

    $query_container = \Drupal::getContainer()->get('flexinfo.querynode.service');
    $query = $query_container->queryNidsByBundle('win');

    if ($ave_win) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_win', $ave_win - $diff_win, '>');
      $query->condition($group);

      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_win', $ave_win + $diff_win, '<');
      $query->condition($group);
    }

    if ($ave_draw) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_draw', $ave_draw - $diff_draw, '>');
      $query->condition($group);

      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_draw', $ave_draw + $diff_draw, '<');
      $query->condition($group);
    }

    if ($ave_loss) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_loss', $ave_loss - $diff_loss, '>');
      $query->condition($group);

      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_loss', $ave_loss + $diff_loss, '<');
      $query->condition($group);
    }

    if ($tags) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_tags', $tags);
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
  public function queryWinNodesByCondition($ave_win = NULL, $ave_draw = NULL, $ave_loss = NULL, $diff_win = NULL, $diff_draw = NULL, $diff_loss = NULL, $tags = NULL) {
    $nids = $this->queryWinNidsByCondition($ave_win, $ave_draw, $ave_loss, $diff_win, $diff_draw, $diff_loss, $tags);
    $nodes = \Drupal::entityManager()->getStorage('node')->loadMultiple($nids);

    return $nodes;
  }

}
