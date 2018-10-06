<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "hello_block",
 *   admin_label = @Translation("Hello block"),
 *   category = @Translation("Hello World"),
 * )
 */
class HelloBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#markup' => $this->t('Hello, World!'),
    );
  }

  /**
    * {@inheritdoc}
    */
   public function blockForm($form, FormStateInterface $form_state) {
     $form = parent::blockForm($form, $form_state);

     $config = $this->getConfiguration();

     $form['hello_block_name'] = [
       '#type' => 'textfield',
       '#title' => $this->t('Who'),
       '#description' => $this->t('Who do you want to say hello to?'),
       '#default_value' => isset($config['hello_block_name']) ? $config['hello_block_name'] : '',
     ];

     return $form;
   }

}
