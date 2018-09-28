<?php
/**
 * @file
 * Contains \Drupal\batchinfo\Plugin\QueueWorker\UpdateGameJsonQueue.
 */

namespace Drupal\batchinfo\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;

/**
 * Processes Tasks for batchinfo.
 *
 * @QueueWorker(
 *   id = "HomepageCacheQueue",
 *   title = @Translation("batchinfo task worker: Update Game Json Queue"),
 *   cron = {"time" = 360}
 * )
 */
class UpdateGameJsonQueue extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    return;
  }

}
