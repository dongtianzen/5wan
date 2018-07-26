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
    $content = '';
    $content .= '
      <div class="container vue-example-wrapper">
        <div id="vueapp" class="container">
          <h5>Vue Example</h5>
          <div id="people">
            <h5>{{message}}</h5>
          </div>
        </div>
      </div>

      <hr />
      <br />

      <template id="components-demo">
        <h5>components-demo</h5>
        <button-counter></button-counter>
      </template>

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
      '#type' => 'inline_template',
      'page' => [
        '#type' => 'page',
        '#title' => 'ccccc',
        '#show_messages' => TRUE,
        'content' => $content,
      ],
    );

    $build = array(
      '#type' => 'html_tag',
  '#tag' => 'b-alert',
  '#value' => "<button-counter></button-counter>Hello {{ name }}! ",
      // '#markup' => $content,
      '#attached' => array(
        'library' => array(
          'vuepage/vue',
          'vuepage/babel-polyfill',
          'vuepage/bootstrap',
          'vuepage/bootstrap-vue',
          'vuepage/vue_report',
        )
      )
    );

    return $build;
  }

}
