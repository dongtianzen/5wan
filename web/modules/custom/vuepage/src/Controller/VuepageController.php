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
    $content = '
      <div class="container bootstrap-vue-example-wrapper">
        <div id="app">
          <h5>Bootstrap Vue Example</h5>
          <span> Hello {{ name }}! </span>
          <br />
          <b-alert show> Hello {{ name }}! </b-alert>
        </div>
      </div>

      <>
      <div class="container vue-example-wrapper">
        <div id="vueapp" class="container">
          <h5>Vue Example</h5>
          <div class="text-primary">
            <span class="text-primary">show vue message - {{message}}</span>
          </div>
        </div>
      </div>
    ';

    $build = array(
      '#type' => 'inline_template',
      '#template' => $content,
      '#attached' => array(
        'library' => array(
          'vuepage/vue',
          'vuepage/babel-polyfill',
          'vuepage/bootstrap',
          'vuepage/bootstrap-vue',
          'vuepage/vue_report',
        )
      ),
    );


    $build = array(
      '#children' => $content,
      '#attached' => array(
        'library' => array(
          'vuepage/vue',
          'vuepage/babel-polyfill',
          'vuepage/bootstrap',
          'vuepage/bootstrap-vue',
          'vuepage/vue_report',
        )
      ),
    );

    // $build = array(
    //   '#markup' => \Drupal\Core\Render\Markup::create($content),
    //   '#attached' => array(
    //     'library' => array(
    //       'vuepage/vue',
    //       'vuepage/babel-polyfill',
    //       'vuepage/bootstrap',
    //       'vuepage/bootstrap-vue',
    //       'vuepage/vue_report',
    //     )
    //   ),
    // );


    return $build;
  }

}
