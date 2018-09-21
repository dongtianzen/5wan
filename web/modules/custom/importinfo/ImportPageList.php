<?php

/**
 * @file
 * import CSV file, print it for search
 */

/**
 *
 require_once(DRUPAL_ROOT . '/modules/custom/importinfo/ImportPageList.php');
 $ImportPageList = new ImportPageList();
 $ImportPageList->printJsonAsArray();
 */
class ImportPageList {

  /**
   *
   */
  public function readJsonFromUrl($feed_url = NULL) {
    $feed_url = 'http://localhost:8888/5wan/web/sites/default/files/json/5wan/currentGameList.json';
    $output = file_get_contents($feed_url);
    $output = json_decode($output, TRUE);

    return $output;
  }

  /**
   *
   */
  public function printJsonAsArray() {
    $output = [];

    $prefix_string = 'NewGame.value.';

    $json_content = $this->readJsonFromUrl();

    foreach ($json_content as $key => $row) {
      $game_info = NULL;
      foreach ($row as $subkey => $subrow) {

        $game_info .= $prefix_string . 'default_' . $subkey . ' = ' . $subrow . ';';
        $game_info .= '<br />';
      }

      dpm($game_info);

    }

    return $output;
  }

}


// NewGame.value.default_ave_win = 1.80;
// NewGame.value.default_diff_win = 0.06;

// NewGame.value.default_ave_draw = 3.72;
// NewGame.value.default_diff_draw = 0.1;

// NewGame.value.default_ave_loss = 4.3;
// NewGame.value.default_diff_loss = 0.2;

// NewGame.value.default_tags = ['英超', '英冠'];
// NewGame.value.default_name_home = '布赖顿';
// NewGame.value.default_name_away = '富勒姆';
