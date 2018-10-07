<?php

/**
 * @file
 */
namespace Drupal\vuepage\Content;

use Drupal\Core\Url;

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
    $output .= '<table class="table table-striped table-hover">';
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
    foreach ($table_keys as $key => $value) {
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
      "date_time" => 'Date',
      "name_home" => 'Home',
      "name_away" => 'Away',
      "tags" => 'Tag',
      "ave_win" => 'Win',
      "ave_draw" => 'Draw',
      "ave_loss" => 'Loss',
      "ini_win" => 'Ini Win',
      "ini_draw" => 'Draw',
      "ini_loss" => 'Loss',
      "num_company" => 'Num',
      "variation_end_win" => 'Var Win',
      "variation_end_draw" => 'Draw',
      "variation_end_loss" => 'Loss',
      "variation_ini_win" => 'Var Ini Win',
      "variation_ini_draw" => 'Draw',
      "variation_ini_loss" => 'Loss',
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
    foreach ($json_array as $key => $row) {
      $output .= '<tr>';

      foreach ($table_keys as $subkey => $subrow) {
        $output .= '<td>';
          if ($subkey == 'name_home') {
            $url = Url::fromUserInput('/vuepage/game/info/' . $key, array('attributes' => array('class' => array('color-fff'))));
            $output .= \Drupal::l($row[$subkey], $url);
          }
          elseif ($subkey == 'name_away') {
            $url = Url::fromUri('http://odds.500.com/fenxi/ouzhi-' . $key . '.shtml');
            $output .= \Drupal::l($row[$subkey], $url);
          }
          else {
            $output .= $row[$subkey];
          }
        $output .= '</td>';
      }

      $output .= '</tr>';
    }


    return $output;
  }


}
