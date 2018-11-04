<?php

/**
 * @file
 * Contains \Drupal\batchinfo\Content\SyncJsonToTerm.
 */

/**
 * An example controller.
   $SyncJsonToTerm = new SyncJsonToTerm();
   $SyncJsonToTerm->runCreateTermsWithFieldsValue();
 */

namespace Drupal\batchinfo\Content;

use Symfony\Component\HttpFoundation\JsonResponse;

class SyncJsonToTerm {

  public $vid;
  public $termJsonContent;

  public function __construct() {
    $this->vid = 'tag';
    $this->termJsonContent = $this->getShenzhenList();
    $this->termJsonContent = array();
  }

  public function getTermJsonContent() {
    return $this->termJsonContent;
  }

  public function runBatchinfoCreateTermEntity($json_content_piece = NULL) {
    if (TRUE) {
      $check_term_exist = \Drupal::getContainer()
        ->get('flexinfo.term.service')
        ->getTidByTermName($json_content_piece[0], $vid = $this->vid);

      if ($check_term_exist) {
        dpm('The term exist - ' . $json_content_piece[0]);
        return;
      }
      else {
        $this->runCreateTermsWithFieldsValue($json_content_piece);
      }
    }

    return;
  }

  public function runCreateTermsWithFieldsValue($json_content_piece) {
    $fields_value = array(
      array(
        'field_name' => 'field_code_name',
        'value' => array($json_content_piece[1]),
      ),
      array(
        'field_name' => 'field_code_listing_date',
        'value' => array($json_content_piece[2]),
      )
    );

    \Drupal::getContainer()
      ->get('flexinfo.term.service')
      ->entityCreateTermWithFieldsValue($json_content_piece[0], $vid = $this->vid, $fields_value);
  }

  public function getShenzhenList() {
    return $list = array(
      array("000001", "平安银行", "1991-04-03"),
      array("000002", "万科", "1991-01-29"),
      array("000004", "国农科技", "1991-01-14"),
      array("000005", "世纪星源", "1990-12-10"),
      array("000006", "深振业", "1992-04-27"),
    );
  }

}
