<?php

namespace Drupal\mongo\Services;

/**
 *
 $output = \Drupal::getContainer()
   ->get('mongo.driver.set')
   ->runDatabaseStats();
 */

/**
 * Class MongoDriverSet.
 */
// class MongoDriverSet implements MongoDriverSetInterface {
class MongoDriverSet {

  /**
   *
   */
  public $manager;

  /**
   * Constructs a new MongoDriverSet object.
   */
  public function __construct() {
    $this->manager = new \MongoDB\Driver\Manager("mongodb://localhost:27017");
  }

  /**
   *
   */
  public function getBulkWrite() {
    $bulk = new \MongoDB\Driver\BulkWrite;

    return $bulk;
  }

  /**
   * insert
   */
  function bulkInsertFields($doc = []) {
    // $doc = ['name' => 'Toyota', 'price' => 26700];
    // $doc = ['_id' => new MongoDB\BSON\ObjectID, 'name' => 'Toyota', 'price' => 26700];

    $bulk = $this->getBulkWrite();
    $bulk->insert($doc);

    $this->manager->executeBulkWrite('5wan.game', $bulk);
  }

  /**
   * update
   * The MongoDB\BSON\ObjectID generates a new ObjectId. It is a value used to uniquely identify documents in a collection.
   */
  function bulkUpdateFields($doc = []) {
    // $doc = ['name' => 'Audi'], ['$set' => ['price' => 52000]];

    $bulk = $this->getBulkWrite();
    $bulk->update($doc);

    $this->manager->executeBulkWrite('5wan.game', $bulk);
  }

  /**
   * delete
   */
  function bulkDeleteFields($doc = []) {
    // $doc = ['name' => 'Hummer'];

    $bulk = $this->getBulkWrite();
    $bulk->delete($doc);

    $this->manager->executeBulkWrite('5wan.game', $bulk);
  }

  /**
   * MongoDB\Driver\Query
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
   * MongoDB\Driver\Query
   * Projections
   * Projections can be used to specify which fields should be returned.
   * Here we hide the '_id' field and 'ave_win' field 但是显示其它的.
   [
     '_id' => 0,
     'ave_win' => 0,
   ]
   * 只显示下面两个指定的field
   [
     '_id' => 0,
     'ave_win' => 1,
     'ave_draw' => 1,
   ]
   *
   *
   $output = \Drupal::getContainer()
     ->get('mongo.driver.set')
     ->runQueryFieldsWithHideFields();
   */
  function runQueryFieldsWithHideFields() {
    $options = [
      "projection" => [
        '_id' => 0,
        'ave_win' => 1,
        'ave_draw' => 1,
      ]
    ];
    $filter = [];

    $query = new \MongoDB\Driver\Query($filter, $options);

    $rows = $this->manager->executeQuery("5wan.game", $query);

    foreach ($rows as $row) {
      print_r($row);
    }
  }

  /**
   * Database statistics
   */
  function runDatabaseStats() {
    $command = ["dbstats" => 1];

    $stats = new \MongoDB\Driver\Command($command);

    $result = $this->manager->executeCommand("5wan", $stats);
    $stats = current($result->toArray());

    print_r($stats);
  }

}
