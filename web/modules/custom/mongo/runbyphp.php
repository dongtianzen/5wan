<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/mongo/runbyphp.php');
  _run_create_fields();
 */

/**
 * Execute a database query
 */
function _run_create_fields() {

  // $MongoClient = new MongoClient();

  $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

  // insert
  // $bulk = new MongoDB\Driver\BulkWrite;
  // $bulk->insert(['ave_win' => 6]);
  // $manager->executeBulkWrite('5wan.game', $bulk);

  // query
  // $filter = ['ave_win' => ['$gt' => 1]];
  // $filter = [];
  // $options = [
  //   'projection' => [
  //     '_id' => 0,
  //     'ave_win' => 0,
  //   ],
  //   'sort' => ['x' => -1],
  //   'maxTimeMS' => 3000,
  // ];

  // $query = new MongoDB\Driver\Query($filter, $options);
  // $cursor = $manager->executeQuery('5wan.game', $query);

  // foreach ($cursor as $document) {
  //   dpm(999);
  //   dpm($document->ave_win);
  //   // ksm($document);
  //   var_dump($document);
  // }

  // Database statistics
  $stats = new MongoDB\Driver\Command(["dbstats" => 1]);
  $result = $manager->executeCommand("5wan", $stats);

  $stats = current($result->toArray());

  print_r($stats);


}
