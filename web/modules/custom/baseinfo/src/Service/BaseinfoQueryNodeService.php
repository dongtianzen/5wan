<?php

/**
 * @file
 * Contains Drupal\baseinfo\Service\BaseinfoQueryNodeService.php.
 */

namespace Drupal\baseinfo\Service;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Query\QueryFactory;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\flexinfo\Service\FlexinfoQueryNodeService;

/**
 * An example Service container.
   \Drupal::getContainer()->get('baseinfo.querynode.service')->wrapperCmeNidsByUser();
 *
 */
class BaseinfoQueryNodeService extends FlexinfoQueryNodeService {

  /**
   * dashjson/game/fields/value?ave_win=2.76&tags[]=荷乙&tags[]=荷甲
   */
  public function queryWinNidsByUrlRequest($ave_win = NULL, $ave_draw = NULL, $ave_loss = NULL, $diff_win = NULL, $diff_draw = NULL, $diff_loss = NULL, $tags = array(), $home = NULL, $away = NULL) {
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
    // if (isset($request_array['diff_win'])) {
    //   $diff_win = $request_array['diff_win'];
    // }
    // if (isset($request_array['diff_draw'])) {
    //   $diff_draw = $request_array['diff_draw'];
    // }
    // if (isset($request_array['diff_loss'])) {
    //   $diff_loss = $request_array['diff_loss'];
    // }

    /**
     * manually set form diff value from \Drupal::state()
     */
    $diff_array = \Drupal::state()->get('game_query_diff_value');
    $diff_win  = isset($diff_array['win']) ? $diff_array['win']: 0.2;
    $diff_draw = isset($diff_array['draw']) ? $diff_array['draw']: 0.2;
    $diff_loss = isset($diff_array['loss']) ? $diff_array['loss']: 0.2;

    //
    if (isset($request_array['tags'])) {
      $tags = $request_array['tags'];
    }

    //
    if (isset($request_array['home'])) {
      $home = $request_array['home'];
    }
    if (isset($request_array['away'])) {
      $away = $request_array['away'];
    }

    $output = $this->queryWinNidsByCondition($ave_win, $ave_draw, $ave_loss, $diff_win, $diff_draw, $diff_loss, $tags, $home, $away);

    return $output;
  }

  /**
   *
   */
  public function queryWinNodesByUrlRequest() {
    $nids = $this->queryWinNidsByUrlRequest();
    $nodes = \Drupal::entityManager()->getStorage('node')->loadMultiple($nids);

    return $nodes;
  }

  /**
   *
   */
  public function queryWinNidsByCondition($ave_win = NULL, $ave_draw = NULL, $ave_loss = NULL, $diff_win = 0.1, $diff_draw = 0.2, $diff_loss = 0.2, $tags = array(), $home = NULL, $away = NULL) {

    //
    $query_container = \Drupal::getContainer()->get('flexinfo.querynode.service');
    $query = $query_container->queryNidsByBundle('win');

    $group = $query_container->groupStandardByFieldValue($query, 'field_win_num_company', 50, '>');
    $query->condition($group);

    $group = $query_container->groupStandardByFieldValue($query, 'field_win_outlier', NULL, 'IS NULL');
    $query->condition($group);

    if ($ave_win) {
      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_win', ($ave_win - $diff_win), '>');
      $query->condition($group);

      $group = $query_container->groupStandardByFieldValue($query, 'field_win_ave_win', ($ave_win + $diff_win), '<');
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


    // if ($tags) {
    //   if (is_array($tags)) {
    //     // dashjson/game/fields/value?ave_win=2.76&tags[]=荷乙&tags[]=荷甲
    //     $group = $query_container->groupStandardByFieldValue($query, 'field_win_tags.entity.name', $tags, 'IN');
    //   }
    //   else {
    //     // dashjson/game/fields/value?ave_win=2.76&tags=荷甲
    //     $group = $query_container->groupStandardByFieldValue($query, 'field_win_tags.entity.name', $tags);
    //   }
    //   $query->condition($group);
    // }

    // if ($home || $away) {
    //   $group = $query->orConditionGroup()
    //     ->condition('field_win_name_home', $home, 'CONTAINS')
    //     ->condition('field_win_name_away', $away, 'CONTAINS');
    //     // ->condition('field_win_name_home', array($home, $away), 'IN')
    //     // ->condition('field_win_name_away', array($home, $away), 'IN');
    //   $query->condition($group);
    // }


    // $query->sort('field_win_date', 'DESC');
    // $query->range(0, 200000);
    $nids = $query_container->runQueryWithGroup($query);

    return $nids;
  }

  /**
   *
   */
  public function queryWinNodesByCondition($ave_win = NULL, $ave_draw = NULL, $ave_loss = NULL, $diff_win = NULL, $diff_draw = NULL, $diff_loss = NULL, $tags = array(), $home = NULL, $away = NULL) {
    $nids = $this->queryWinNidsByCondition($ave_win, $ave_draw, $ave_loss, $diff_win, $diff_draw, $diff_loss, $tags, $home, $away);
    $nodes = \Drupal::entityManager()->getStorage('node')->loadMultiple($nids);

    return $nodes;
  }

}
