<?php

namespace Drupal\mongo\Services;

/**
 *
 $output = \Drupal::getContainer()
   ->get('mongo.driver.set')
   ->runDatabaseStats();
 */
class MongoDriverSet {

  function commandSet() {
    $output = new MongoDriverSetCommand();

    return $output;
  }

  function bulkSet() {
    $output = new MongoDriverSetBulk();

    return $output;
  }

}

/**
 * Class MongoDriverSet.
 */
// class MongoDriverSet implements MongoDriverSetInterface {
class MongoDriverSetBasic {

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

}

class MongoDriverSetCommand extends MongoDriverSetBasic {

  /**
   *
   */
  function runExecuteCommand($options, $game_id = NULL) {
    $command = new \MongoDB\Driver\Command($options);
    $cursor = $this->manager->executeCommand("5wan", $command);
    $response = $cursor->toArray();

    print_r($response);

    if ($game_id) {
      $count_num = $response[0]->n;
      if ($count_num > 1) {
        dpm($game_id . ' have more than 1');
      }
    }
  }

  /**
   *
   */
  function runCommandCount($game_id = '') {
    $options = [
      'count' => "game",
      'query' => [
        'id5' => $game_id
      ]
    ];

    $this->runExecuteCommand($options, $game_id);
  }

  /**
   * Database statistics
   */
  function runDatabaseStats() {
    $options = ["dbstats" => 1];

    $this->runExecuteCommand($options);
  }

}

class MongoDriverSetBulk extends MongoDriverSetBasic {

  /**
   *
   */
  public function getBulkWrite() {
    $bulk = new \MongoDB\Driver\BulkWrite;

    return $bulk;
  }

  /**
   *
   */
  public function runExecuteBulkWriteInsert($doc) {
    $bulk = $this->getBulkWrite();
    $bulk->insert($doc);

    $result = $this->manager->executeBulkWrite('5wan.game', $bulk);
  }

  /**
   *
   */
  public function runExecuteBulkWriteUpdate($query, $update) {
    $updateOptions = ['multi' => false, 'upsert' => false];

    $bulk = $this->getBulkWrite();
    $bulk->update($query, $update);

    $updateResult = $this->manager->executeBulkWrite('5wan.game', $bulk, $updateOptions);

    $count = $updateResult->getModifiedCount();
    dpm($count);
  }

  /**
   *
   */
  public function runExecuteBulkWriteDelete($filter, $doc) {
    $bulk = $this->getBulkWrite();
    $bulk->delete($filter, $doc);

    $result = $this->runExecuteBulkWrite($bulk);
  }

  /**
   * insert
   */
  function bulkInsertFields($doc = []) {
    // $doc = ['name' => 'Toyota', 'price' => 26700];
    // $doc = ['_id' => new MongoDB\BSON\ObjectID, 'name' => 'Toyota', 'price' => 26700];

    $this->runExecuteBulkWriteInsert($doc);
  }

  /**
   *
   */
  function bulkFindUpdateInc($game_id = '', $value = '') {
    $query = ['game_id' => $game_id];
    $update = [
      '$inc' => [
        'id5' => $value
      ]
    ];

    $this->runExecuteBulkWriteUpdate($query, $update);
  }

  /**
   *
   */
  function bulkFindUpdateSet($query = [], $update = []) {
    $query = ['game_id' => 35];
    $update = [
      '$set' => [
        'ew' => 2.78
      ]
    ];

    $this->runExecuteBulkWriteUpdate($query, $update);
  }

  /**
   *
   */
  function bulkFindUpdateSetFromJson($query = [], $update_set = []) {
    $update = [
      '$set' => $update_set
    ];

    $this->runExecuteBulkWriteUpdate($query, $update);
  }

  /**
   * delete
   */
  function bulkDeleteFields($doc = []) {
    $filter = ['name' => 'Hummer'];
    $doc = ['limit' => 1];

    $this->runExecuteBulkWriteDelete($filter, $doc);
  }

}

class MongoDriverSetQuery extends MongoDriverSetBasic {

  /**
   *
   */
  public function runExecuteQuery($filter, $options) {
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

    $this->runExecuteQuery($filter, $options);
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

    $this->runExecuteQuery($filter, $options);
  }

}
