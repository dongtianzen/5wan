<?php

/**
 * @file
 * Contains \Drupal\vuepage\Controller\VuepageController.
 */

namespace Drupal\vuepage\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * An example controller.
 */
class VuepageController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function vuePage() {
    $markup = '';
    $markup .= '
      <div class="container vue-example-wrapper">
        <div id="vueapp" class="container">
          <h5>Vue Example</h5>
          <div id="people">
            <h5>{{message}}</h5>
          </div>
        </div>
      </div>

      <br />
      <hr />
      <br />

      <div class="container bootstrap-vue-example-wrapper">
        <div id="app">
          <h5>Bootstrap Vue Example</h5>
          <b-alert show> Hello {{ name }}! </b-alert>
        </div>
      </div>

    ';

    $build = array(
      '#type' => 'html',
      'page' => [
        '#type' => 'page',
        '#title' => 'Some page',
        'content' => $markup,
        '#attached' => [
          // At least one of these have to have value,
          // otherwise the head placeholder won't get replaced.
          'html_head_link' => [],
          'html_head' => []
        ]
      ],
      '#attached' => array(
        'library' => array(
          'vuepage/vue',
          // Add these after vue.js
          'vuepage/babel-polyfill',
          'vuepage/bootstrap',
          'vuepage/bootstrap-vue',
          'vuepage/vue_report',
        ),
      ),
    );

    $build['page']['#attached']['html_head'][] = [[
         '#type' => 'html_tag',
         '#tag' => 'meta',
         '#attributes' => array(
           'name' => 'Sometag',
           'content' => 'somevalue',
         ),
       ], 'someid'];

    return $build;
  }

}
