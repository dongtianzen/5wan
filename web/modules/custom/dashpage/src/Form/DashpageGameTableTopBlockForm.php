<?php
/**
 * @file
 * Contains \Drupal\dashpage\Form\DashpageGameTableTopBlockForm.php.
 */

namespace Drupal\dashpage\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 *
 */
class DashpageGameTableTopBlockForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'dashpage_game_table_top_block_form';
  }

  /**
   * {@inheritdoc}.
   */

  public function buildForm(array $form, FormStateInterface $form_state) {
    $diff_array = \Drupal::state()->get('game_query_diff_value');

    $form['diff_win'] = [
      '#type' => 'textfield',
      '#title' => 'Win',
      '#default_value' => isset($diff_array['win']) ? $diff_array['win']: 0.2,
      '#size' => 20,
      '#prefix' => '<div class="float-left col-md-2">',
      '#suffix' => '</div>',
    ];

    $form['diff_draw'] = [
      '#type' => 'textfield',
      '#title' => 'Draw',
      '#default_value' => isset($diff_array['draw']) ? $diff_array['draw']: 0.2,
      '#size' => 20,
      '#prefix' => '<div class="float-left col-md-2">',
      '#suffix' => '</div>',
    ];

    $form['diff_loss'] = [
      '#type' => 'textfield',
      '#title' => 'Loss',
      '#default_value' => isset($diff_array['loss']) ? $diff_array['loss']: 0.2,
      '#size' => 20,
      '#prefix' => '<div class="float-left col-md-2">',
      '#suffix' => '</div>',
    ];

    $form['show'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    $form['#prefix'] = '<div class="container">';
    $form['#suffix'] = '</div>';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message($this->t('Your win value is @win', ['@win' => $form_state->getValue('ave_win')]));

    $diff_array['win'] = $form_state->getValue('diff_win');
    $diff_array['draw'] = $form_state->getValue('diff_draw');
    $diff_array['loss'] = $form_state->getValue('diff_loss');

    \Drupal::state()->set('game_query_diff_value', $diff_array);

    $url = Url::fromRoute(
      'dashpage.trend.page',
      [],
      ['query' => ['ave_win' => $ave_win, 'tags' => $tags]]
    );
    $form_state->setRedirectUrl($url);
  }

}
