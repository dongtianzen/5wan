<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/mongo/runbyphp.php');

  $MongoDriverManager = new MongoDriverManager();
  $MongoDriverManager->runQueryFieldsWithHideFields();
 */

/**
 * Execute a database query
 *
 * http://zetcode.com/db/mongodbphp/
 */

/**
 *
 */
class MongoDriverManager {

  /**
   *
   */
  public $manager;

  public function __construct() {
    $this->manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
  }

  /**
   * insert
   */
  function runInsertFields() {
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->insert(['ave_win' => 6]);

    $this->manager->executeBulkWrite('5wan.game', $bulk);
    // $doc = ['_id' => new MongoDB\BSON\ObjectID, 'name' => 'Toyota', 'price' => 26700];
    // $bulk->insert($doc);
  }

  /**
   * update
   * The MongoDB\BSON\ObjectID generates a new ObjectId. It is a value used to uniquely identify documents in a collection.
   */
  function runUpdateFields() {
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->update(['name' => 'Audi'], ['$set' => ['price' => 52000]]);

    $this->manager->executeBulkWrite('5wan.game', $bulk);
  }

  /**
   * delete
   */
  function runDeleteFields() {
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->delete(['name' => 'Hummer']);

    $this->manager->executeBulkWrite('5wan.game', $bulk);
  }

  /**
   * query
   */
  function runQueryFields() {
    $filter = ['ave_win' => ['$gt' => 1]];
    $filter = ['name' => 'Volkswagen'];
    $filter = [];
    $options = [
      'projection' => [
        '_id' => 0,
        'ave_win' => 0,
      ],
      'sort' => ['ave_win' => -1],    // 1 or -1
      'maxTimeMS' => 3000,
      'limit' => 5
    ];
    $options = [];

    $query = new MongoDB\Driver\Query($filter, $options);
    $rows = $this->manager->executeQuery('5wan.game', $query);

    foreach ($rows as $document) {
      dpm($document->ave_win);
      // ksm($document);
      var_dump($document);
    }
  }

  /**
   * query
   * Projections
   * Projections can be used to specify which fields should be returned.
   * Here we hide the '_id' field and 'ave_win' field when the return result.
   */
  function runQueryFieldsWithHideFields() {
    $options = [
      "projection" => [
        '_id' => 0,
        'ave_win' => 0,
      ]
    ];
    $filter = [];
    $query = new MongoDB\Driver\Query($filter, $options);

    $rows = $this->manager->executeQuery("5wan.game", $query);

    foreach ($rows as $row) {
      print_r($row);
    }
  }

  /**
   * Database statistics
   */
  function runDatabaseStats() {
    $stats = new MongoDB\Driver\Command(["dbstats" => 1]);
    $result = $this->manager->executeCommand("5wan", $stats);

    $stats = current($result->toArray());

    print_r($stats);
  }

}

/**
 *
 require_once(DRUPAL_ROOT . '/modules/custom/mongo/runbyphp.php');

 $MongoClient = new MongoClient();
 $MongoClient->runListDatabases();

 */
class MongoClient {

  public $client;
  public function __construct() {
    $this->client = new MongoDB\Client('mongodb://localhost:27017');
  }

  /**
   * Database statistics
   */
  function runListDatabases() {
    var_dump($this->client->listDatabases());
  }

}
