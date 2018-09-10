<?php

/**
 * @file
 * Contains \Drupal\dashjson\Controller\DashjsonController.
 */

namespace Drupal\dashjson\Controller;

use Drupal\Component\Utility\Timer;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormState;
use Drupal\Core\Url;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Drupal\dashjson\Content\DashjsonContentGenerator;

/**
 * An example controller.
 */
class DashjsonController extends ControllerBase {

  /**
   *
   */
  public function gameDataset() {
    $DashjsonContentGenerator = new DashjsonContentGenerator();
    $object_content_data = $DashjsonContentGenerator->getGameDataset();

    return new JsonResponse($object_content_data);

    // debug output as JSON format
    $build = array(
      '#type' => 'markup',
      '#markup' => json_encode($object_content_data),
    );

    return $build;
  }


}
