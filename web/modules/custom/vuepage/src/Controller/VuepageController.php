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
  public function basicContent() {
    $content = '
      <div class="container bootstrap-vue-example-wrapper">
        <div id="app">
          <h5>Bootstrap Vue Example</h5>
          <span> Hello {{ name }}! </span>
          <br />
          <b-alert show> Hello {{ name }}! </b-alert>
        </div>
      </div>

      <hr />
      <div class="container vue-example-wrapper">
        <div id="vueapp" class="container">
          <h5>Vue Example</h5>
          <div class="text-primary">
            <span class="text-primary">show vue message - {{message}}</span>
          </div>
        </div>
      </div>
    ';

    return $content;
  }

  /**
   * {@inheritdoc}
   */
  public function vuePage() {
    $content = $this->basicContent();

    $build = array(
      '#children' => $content,
      '#attached' => array(
        'library' => array(
          'vuepage/vue',
          'vuepage/babel-polyfill',
          'vuepage/bootstrap',
          'vuepage/bootstrap-vue',
          'vuepage/axios',
          'vuepage/vuetable-2',
          'vuepage/vue_report',
          'vuepage/vue_table_js',
        )
      ),
    );


    return $build;
  }

}
