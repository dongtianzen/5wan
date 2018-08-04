<?php

/**
 * @file
 * Contains Drupal\baseinfo\Service\BaseinfoQueryTermService.php.
 */
namespace Drupal\baseinfo\Service;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Query\QueryFactory;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\flexinfo\Service\FlexinfoQueryTermService;

/**
 * An example Service container.
 */
class BaseinfoQueryTermService extends FlexinfoQueryTermService {

  /**
   * @param Learning Objective's tid is 2451
            radios is 2493
   \Drupal::getContainer()->get('baseinfo.queryterm.service')->wrapperQuestionTidsOnlyRadios();
   */
  public function wrapperQuestionTidsOnlyRadios($question_tids = array()) {
    $radios_tid = \Drupal::getContainer()
      ->get('flexinfo.term.service')
      ->getTidByTermName($term_name = 'radios', $vocabulary_name = 'fieldtype');

    //
    $query = $this->queryTidsByBundle('questionlibrary');

    $group = $this->groupStandardByFieldValue($query, 'tid', $question_tids, 'IN');
    $query->condition($group);

    $group = $this->groupStandardByFieldValue($query, 'field_queslibr_fieldtype', $radios_tid);
    $query->condition($group);

    $output = $this->runQueryWithGroup($query);

    return $output;
  }

  /**
   * @param Learning Objective's tid is 2451
            radios is 2493
   */
  public function wrapperQuestionTidsByRadiosByLearningObjective($question_tids = array(), $learning_objective = TRUE) {
    $radios_tid = \Drupal::getContainer()
      ->get('flexinfo.term.service')
      ->getTidByTermName($term_name = 'radios', $vocabulary_name = 'fieldtype');

    $learning_objective_tid = \Drupal::getContainer()
      ->get('flexinfo.term.service')
      ->getTidByTermName($term_name = 'Learning Objective', $vocabulary_name = 'questiontype');

    //
    $query = $this->queryTidsByBundle('questionlibrary');

    $group = $this->groupStandardByFieldValue($query, 'tid', $question_tids, 'IN');
    $query->condition($group);

    $group = $this->groupStandardByFieldValue($query, 'field_queslibr_fieldtype', $radios_tid);
    $query->condition($group);

    if ($learning_objective) {
      $group = $this->groupStandardByFieldValue($query, 'field_queslibr_questiontype', $learning_objective_tid);
      $query->condition($group);
    }
    else {
      // $query->notExists('field_queslibr_questiontype');   // the field value is empty

      $group = $this->groupStandardByFieldValue($query, 'field_queslibr_questiontype', $learning_objective_tid, 'NOT IN');
      $query->condition($group);
    }

    $output = $this->runQueryWithGroup($query);

    return $output;
  }

  /**
   *
   */
  public function wrapperFieldtypeQuestionTidsFromEvaluationform($fieldtype = NULL, $evaluationform_term = NULL) {
    $selectkey_tid= \Drupal::getContainer()
      ->get('flexinfo.term.service')
      ->getTidByTermName($term_name = $fieldtype, $vocabulary_name = 'fieldtype');

    $all_question_tids = \Drupal::getContainer()
      ->get('flexinfo.field.service')
      ->getFieldAllTargetIds($evaluationform_term, 'field_evaluationform_questionset');

    $output = \Drupal::getContainer()
      ->get('flexinfo.queryterm.service')
      ->wrapperStandardTidsByTidsByField($all_question_tids, 'questionlibrary', 'field_queslibr_fieldtype', $selectkey_tid);

    return $output;
  }

  /**
   *
   */
  public function wrapperMultipleQuestionTidsFromEvaluationform($evaluationform_term = NULL) {
    $radios_tid= \Drupal::getContainer()
      ->get('flexinfo.term.service')
      ->getTidByTermName($term_name = 'radios', $vocabulary_name = 'fieldtype');

    $question_tids_current_form = \Drupal::getContainer()
      ->get('flexinfo.field.service')
      ->getFieldAllTargetIds($evaluationform_term, 'field_evaluationform_questionset');

    //
    $query_container = \Drupal::getContainer()->get('flexinfo.queryterm.service');
    $query = $query_container->queryTidsByBundle('questionlibrary');

    // filter by tids
    $group = $query_container->groupStandardByFieldValue($query, 'tid', $question_tids_current_form, 'IN');
    $query->condition($group);

    $group = $query_container->groupStandardByFieldValue($query, 'field_queslibr_fieldtype', $radios_tid);
    $query->condition($group);

    $group = $query_container->groupStandardByFieldValue($query, 'field_queslibr_relatedfield', NULL, 'IS NOT NULL');
    $query->condition($group);

    $output = $query_container->runQueryWithGroup($query);

    return $output;
  }

}
