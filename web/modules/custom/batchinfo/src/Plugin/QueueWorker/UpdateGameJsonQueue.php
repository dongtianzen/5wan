<?php
/**
 * @file
 * Contains \Drupal\batchinfo\Plugin\QueueWorker\UpdateGmaeJsonQueue.
 */

namespace Drupal\batchinfo\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;

/**
 * Processes Tasks for batchinfo.
 *
 * @QueueWorker(
 *   id = "update_game_json_queue",
 *   title = @Translation("batchinfo task worker: Update Game Json Queue"),
 *   cron = {"time" = 360}
 * )
 */
class UpdateGmaeJsonQueue extends QueueWorkerBase {
  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    $RunGenerateCache = new RunGenerateCache();
    RunGenerateCache::getPageCacheContent($data);
  }

}
