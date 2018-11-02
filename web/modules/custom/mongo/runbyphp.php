<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/mongo/runbyphp.php');
  _run_create_fields();
 */

/**
 * Execute a database query
 *
 * http://zetcode.com/db/mongodbphp/
 */
function _run_create_fields() {

  // $MongoClient = new MongoClient();

  // $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

  $client = new MongoDB\Client('mongodb://localhost:27017');
  var_dump($client->listDatabases());

  /**
   * insert
   */
  // $bulk = new MongoDB\Driver\BulkWrite;
  // $bulk->insert(['ave_win' => 6]);
  // $manager->executeBulkWrite('5wan.game', $bulk);

  /**
   * update and delete
   * The MongoDB\BSON\ObjectID generates a new ObjectId. It is a value used to uniquely identify documents in a collection.
   */
  // $doc = ['_id' => new MongoDB\BSON\ObjectID, 'name' => 'Toyota', 'price' => 26700];
  // $bulk->insert($doc);
  // $bulk->update(['name' => 'Audi'], ['$set' => ['price' => 52000]]);
  // $bulk->delete(['name' => 'Hummer']);

  /**
   * query
   */
  // $filter = ['ave_win' => ['$gt' => 1]];
  // $filter = [ 'name' => 'Volkswagen' ];
  // $filter = [];
  // $options = [
  //   'projection' => [
  //     '_id' => 0,
  //     'ave_win' => 0,
  //   ],
  //   'sort' => ['ave_win' => -1],    // 1 or -1
  //   'maxTimeMS' => 3000,
  //   'limit' => 5
  // ];
  // $options = [];

  // $query = new MongoDB\Driver\Query($filter, $options);
  // $rows = $manager->executeQuery('5wan.game', $query);

  // foreach ($rows as $document) {
  //   dpm(999);
  //   dpm($document->ave_win);
  //   // ksm($document);
  //   var_dump($document);
  // }

  /**
   * Database statistics
   */
  // $stats = new MongoDB\Driver\Command(["dbstats" => 1]);
  // $result = $manager->executeCommand("5wan", $stats);

  // $stats = current($result->toArray());

  // print_r($stats);


  //
  /**
   * Projections
   * Projections can be used to specify which fields should be returned.
   * Here we hide the '_id' field and 'ave_win' field when the return result.
   */
  // $options = [
  //   "projection" => [
  //     '_id' => 0,
  //     'ave_win' => 0,
  //   ]
  // ];
  // $filter = [];
  // $query = new MongoDB\Driver\Query($filter, $options);

  // $rows = $manager->executeQuery("5wan.game", $query);

  // foreach ($rows as $row) {

  //        print_r($row);
  // }


}
