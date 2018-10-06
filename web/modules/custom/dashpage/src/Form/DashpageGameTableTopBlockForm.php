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
    $form['htmltext'] = [
      '#type' => 'label',
      '#title' => '<h5>Diff Form</h5>',
      '#prefix' => '<div class="clear-both">',
      '#suffix' => '</div>',
    ];

    $form['diff_win'] = [
      '#type' => 'textfield',
      '#title' => 'Win',
      '#size' => 20,
    ];

    $form['diff_draw'] = [
      '#type' => 'textfield',
      '#title' => 'Draw',
      '#size' => 20,
    ];

    $form['diff_loss'] = [
      '#type' => 'textfield',
      '#title' => 'Loss',
      '#size' => 20,
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

    $ave_win = $form_state->getValue('ave_win');
    $tags = $form_state->getValue('tags');

    $url = Url::fromRoute(
      'dashpage.trend.page',
      [],
      ['query' => ['ave_win' => $ave_win, 'tags' => $tags]]
    );
    $form_state->setRedirectUrl($url);
  }

}
