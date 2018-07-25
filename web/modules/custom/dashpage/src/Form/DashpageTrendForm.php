<?php
/**
 * @file
 * Contains \Drupal\dashpage\Form\DashpageTrendForm.php.
 */

namespace Drupal\dashpage\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 *
 */
class DashpageTrendForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'dashpage_summary_evaluation_form';
  }

  /**
   * {@inheritdoc}.
   */

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['htmltext'] = [
      '#type' => 'label',
      '#title' => '<h5>Summary Form</h5>',
      '#prefix' => '<div class="clear-both">',
      '#suffix' => '</div>',
    ];

    $form['ave_win'] = [
      '#type' => 'textfield',
      '#title' => 'ave_win',
      '#size' => 20,
    ];

    $form['ave_draw'] = [
      '#type' => 'textfield',
      '#title' => 'ave_draw',
      '#size' => 20,
    ];

    $form['ave_loss'] = [
      '#type' => 'textfield',
      '#title' => 'ave_loss',
      '#size' => 20,
    ];

    $form['tags'] = [
      '#type' => 'entity_autocomplete',    // autocomplete_deluxe
      '#title' => 'Tags',
      '#target_type' => 'taxonomy_term',
      '#selection_settings' => [
        'target_bundles' => array('tags'),
      ],
    ];

    $form['tags2'] = [
      '#type' => 'autocomplete_deluxe',
      '#title' => 't2',
      '#target_type' => 'taxonomy_term',
      '#selection_handler' => 'default',
      '#selection_settings' => [
        'target_bundles' => array('tags'),
      ],
      '#size' => 60,
      '#autocomplete_route_name' => 'autocomplete_deluxe.autocomplete',
      '#autocomplete_route_parameters' => array('taxonomy_term', 'default', 'tags'),
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
