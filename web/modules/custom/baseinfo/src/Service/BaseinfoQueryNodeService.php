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
   *
   */
  public function wrapperEvaluationNodeFromMeetingNodes($meeting_nodes = array()) {
    $meeting_nids = \Drupal::getContainer()
      ->get('flexinfo.node.service')
      ->getNidsFromNodes($meeting_nodes);

    $output = \Drupal::getContainer()
      ->get('flexinfo.querynode.service')
      ->nodesByStandardByFieldValue('evaluation', 'field_evaluation_meetingnid', $meeting_nids, 'IN');

    return $output;
  }

  /**
   *
   */
  public function getQuestionAnswerAllDataWithReferUid($meeting_nodes = array(), $question_tid = NULL) {
    $evaluation_nodes = $this->wrapperEvaluationNodeFromMeetingNodes($meeting_nodes);

    $output = array();
    if ($evaluation_nodes && is_array($evaluation_nodes)) {
      foreach ($evaluation_nodes as $evaluation_node) {
        $result = $evaluation_node->get('field_evaluation_reactset')->getValue();

        foreach ($result as $row) {
          if ($row['question_tid'] == $question_tid && $row['question_answer']) {
            $output[$row['refer_uid']][] = $row['question_answer'];
          }
        }
      }
    }

    return $output;
  }

}
