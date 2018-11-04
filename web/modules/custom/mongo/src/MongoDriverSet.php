<?php

namespace Drupal\mongo;

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
  public function __construct($Manager) {
    $this->manager = $Manager;
    // $this->manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
  }

  /**
   * insert
   *

   */
  function runInsertFields($doc = []) {
    // $doc = ['name' => 'Toyota', 'price' => 26700];
    // $doc = ['_id' => new MongoDB\BSON\ObjectID, 'name' => 'Toyota', 'price' => 26700];

    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->insert($doc);

    $this->manager->executeBulkWrite('5wan.game', $bulk);
  }

  /**
   * update
   * The MongoDB\BSON\ObjectID generates a new ObjectId. It is a value used to uniquely identify documents in a collection.
   */
  function runUpdateFields($doc = []) {
    // $doc = ['name' => 'Audi'], ['$set' => ['price' => 52000]];

    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->update($doc);

    $this->manager->executeBulkWrite('5wan.game', $bulk);
  }

  /**
   * delete
   */
  function runDeleteFields($doc = []) {
    // $doc = ['name' => 'Hummer'];

    $bulk = new MongoDB\Driver\BulkWrite;
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
