<?php

/**
 * @file
 */
namespace Drupal\vuepage\Content;

/**
 * An example controller.
 $VuepageTableGenerator = new VuepageTableGenerator();
 $VuepageTableGenerator->demoPage();
 */
class VuepageTableGenerator {

  /**
   * {@inheritdoc}
   * @see https://vuejs.org/v2/examples/grid-component.html
   */
  public function newGameTableContent() {
    $output = NULL;
    $output .= '<table class="table table-striped">';
      $output .= '<thead>';
        $output .= '<tr>';
          $output .= $this->getNewGameTableThead();
        $output .= '</tr>';
      $output .= '</thead>';
      $output .= '<tbody>';
        $output .= $this->getNewGameTableTbody();
      $output .= '</tbody>';
    $output .= '</table>';

    return $output;
  }

  /**
   *
   */
  public function getNewGameTableThead() {
    $output = NULL;

    $table_keys = $this->getNewGameTableKey();
    foreach ($table_keys as $value) {
      $output .= '<th>';
        $output .= $value;
      $output .= '</th>';
    }

    return $output;
  }

  /**
   *
   */
  public function getNewGameTableKey() {
    $output = array(
      "date_time",
      "name_home",
      "name_away",
      "tags",
      "ave_draw",
      "ave_loss",
      "ave_win",
      "ini_draw",
      "ini_loss",
      "ini_win",
      "num_company",
      "variation_end_draw",
      "variation_end_loss",
      "variation_end_win",
      "variation_ini_draw",
      "variation_ini_loss",
      "variation_ini_win",
    );

    return $output;
  }

  /**
   *
   */
  public function getNewGameTableTbody() {
    $file_path = '/sites/default/files/json/5wan/currentGameList.json';
    $json_array = \Drupal::getContainer()
      ->get('flexinfo.json.service')
      ->fetchConvertJsonToArrayFromInternalPath($file_path);

    $table_keys = $this->getNewGameTableKey();

    $output = NULL;
    foreach ($json_array as $row) {
      $output .= '<tr>';

      foreach ($table_keys as $value) {
        $output .= '<td>';
          $output .= $row[$value];
        $output .= '</td>';
      }

      $output .= '</tr>';
    }


    return $output;
  }


}
