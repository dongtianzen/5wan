<?php

namespace Drupal\dashpage\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "dashpage_game_table_top_block",
 *   admin_label = @Translation("Dashpage Game Table Top Block"),
 *   category = @Translation("Dashpage Block"),
 * )
 */
class DashpageGameTableTopBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\dashpage\Form\DashpageGameTableTopBlockForm');

    // or render
    $build = array(
      '#type' => 'markup',
      '#markup' => render($form),
    );

    return $build;

    return array(
      '#markup' => $this->t('Hello, World!'),
    );
  }

}
