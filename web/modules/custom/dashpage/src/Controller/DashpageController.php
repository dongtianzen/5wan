<?php

/**
 * @file
 * Contains \Drupal\dashpage\Controller\DashpageController.
 */

namespace Drupal\dashpage\Controller;

use Drupal\Component\Utility\Timer;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormState;
use Drupal\Core\Url;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Drupal\dashpage\Content\DashpageContentGenerator;

/**
 * An example controller.
 */
class DashpageController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function standardTrendPage() {
    $name = 'time_one';
    Timer::start($name);

    $DashpageContentGenerator = new DashpageContentGenerator();
    $markup = $DashpageContentGenerator->standardTrendPage();

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $markup,
      '#allowed_tags' => \Drupal::getContainer()->get('flexinfo.setting.service')->adminTag(),
    );

    Timer::stop($name);
    dpm(Timer::read($name) . 'ms');

    return $build;
  }

  /**
   *
   */
  public function standardTrendForm() {
    $form = \Drupal::formBuilder()->getForm('Drupal\dashpage\Form\DashpageTrendForm');

    // or render
    $build = array(
      '#type' => 'markup',
      '#markup' => render($form),
    );

    return $build;
  }


}
