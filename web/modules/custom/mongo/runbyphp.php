<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/mongo/runbyphp.php');
  _run_create_fields();
 */


function _run_create_fields() {

  $MongoClient = new MongoClient();


  $db = $MongoClient->5wan; //选择test数据库

  $c = $db->game; //选择一个集合

}
