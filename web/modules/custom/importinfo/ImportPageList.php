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
    $feed_url = 'http://localhost:8888/5wan/web/modules/custom/importinfo/18110.csv';

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
        if (!(strlen($row[1]) > 0)) {
          continue;
        }

        // $row[3] like [18]伯恩利VS曼 联[13]
        $game_teams = explode('VS', $row[3]);
        $game_home = explode(']', $game_teams[0]);
        $game_away = explode('[', $game_teams[1]);

        preg_match_all("/\d{1,2}\.\d{2}/", $row[5], $odd_win);

        $game_info = NULL;

        $game_info .= $prefix_string . 'default_ave_win = ' . $odd_win[0][0] . ';';
        $game_info .= '<br />';
        $game_info .= $prefix_string . 'default_diff_win = ' . 0.05 . ';';
        $game_info .= '<br />';

        $game_info .= $prefix_string . 'default_ave_draw = ' . $odd_win[0][1] . ';';
        $game_info .= '<br />';
        $game_info .= $prefix_string . 'default_diff_draw = ' . 0.1 . ';';
        $game_info .= '<br />';

        $game_info .= $prefix_string . 'default_ave_loss = ' . $odd_win[0][2] . ';';
        $game_info .= '<br />';
        $game_info .= $prefix_string . 'default_diff_loss = ' . 0.1 . ';';
        $game_info .= '<br />';

        $game_info .= $prefix_string . 'default_tags = ["' . $row[1] . '", "' . $row[1] . '"];';
        $game_info .= '<br />';
        $game_info .= $prefix_string . 'default_home = "' . preg_replace('/\s+/', '', $game_home[1]) . '";';
        $game_info .= '<br />';
        $game_info .= $prefix_string . 'default_away = "' . str_replace(' ', '', $game_away[0]) . '";';

        $game_info .= '<br />';
        $game_info .= '<br />';

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
