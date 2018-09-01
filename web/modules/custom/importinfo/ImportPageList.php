<?php

/**
 * @file
 * import CSV file, print it for search
 */

/**
 *
 require_once(DRUPAL_ROOT . '/modules/custom/importinfo/ImportPageList.php');
 $ImportPageList = new ImportPageList();
 $ImportPageList->printCsvArray();
 */
class ImportPageList {

  /**
   *
   */
  public function readCsvFromUrl($feed_url = NULL) {
    $feed_url = 'http://localhost:8888/5wan/web/modules/custom/importinfo/500.csv';

    $output = file_get_contents($feed_url);

    return $output;
  }

  /**
   *
   */
  public function convertCsvToArray($csv_string = NULL) {
    $csv_string = $this->readCsvFromUrl();

    $lines = explode(PHP_EOL, $csv_string);
    $output = array();
    foreach ($lines as $line) {
      $output[] = str_getcsv($line);
    }

    dpm($output);

    return $output;
  }

  /**
   *
   */
  public function printCsvArray() {
    $output = [];

    $prefix_string = 'NewGame.value.';

    $csv_array = $this->convertCsvToArray();
    if ($csv_array) {
      foreach ($csv_array as $key => $row) {
        $game_info = NULL;

        $game_info .= $prefix_string . 'default_ave_win = ' . $row[5] . ';';
        $game_info .= '<br />';
        $game_info .= $prefix_string . 'default_diff_win = ' . 0.05 . ';';

        dpm($game_info);
      }
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
// NewGame.value.default_home = '布赖顿';
// NewGame.value.default_away = '富勒姆';
