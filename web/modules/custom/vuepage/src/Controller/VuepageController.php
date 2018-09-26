<?php

/**
 * @file
 * Contains \Drupal\vuepage\Controller\VuepageController.
 */

namespace Drupal\vuepage\Controller;

use Drupal\Component\Utility\Timer;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Drupal\vuepage\Content\VuepageContentGenerator;
use Drupal\vuepage\Content\VuepageTableGenerator;



/**
 * An example controller.
 */
class VuepageController extends ControllerBase {

  /**
   *
   */
  public function basicContent() {
    $output = '
      <div class="container vue-example-wrapper">
        <div id="appPage">
          <h5>Vue Example</h5>
          <span> Hello {{ name }}! </span>
          <br />
          <b-alert show> Hello {{ name }}! </b-alert>
        </div>
      </div>

      <hr />
      <div class="container vue-example-wrapper">
        <div id="vueAppPage" class="container">
          <h5>Vue Example</h5>
          <div class="text-primary">
            <span class="text-primary">show vue message - {{message}}</span>
          </div>
        </div>
      </div>
    ';

    return $output;
  }

  /**
   * @see sample https://github.com/ratiw/vuetable-2
   */
  public function vuetableContent() {
    $output = '';
    $output .= '<div id="app">';
      $output .= '<div id="table-wrapper" class="ui container">';
        $output .= '<h3>';
          $output .= '<strong>Vuetable-2</strong>';
          $output .= '<span> with Bootstrap 3</span>';
          $output .= '<span>  - https://codepen.io/ratiw/pen/GmJayw</span>';
        $output .= '</h3>';
        $output .= $this->vuetableContentComponent();
      $output .= '</div>';
    $output .= '</div>';

    return $output;
  }

  /**
   * vue template
   */
  public function vuetableContentComponent() {
    // json url is here
    $output = '
      <vuetable-pagination-info ref="paginationInfoTop"
       ></vuetable-pagination-info>

      <filter-bar></filter-bar>

      <vuetable ref="vuetable"
        api-url="https://vuetable.ratiw.net/api/users"
        :fields="fields"
        :sort-order="sortOrder"
        :css="css.table"
        pagination-path=""
        :per-page="10"
        @vuetable:pagination-data="onPaginationData"
        @vuetable:loading="onLoading"
        @vuetable:loaded="onLoaded"
      >
      </vuetable>

      <vuetable-pagination ref="pagination"
        :css="css.pagination"
        @vuetable-pagination:change-page="onChangePage"
      >
      </vuetable-pagination>
    ';

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function vuePage() {
    $content = $this->basicContent();
    $content = $this->vuetableContent();

    $build = array(
      '#children' => $content,
      '#attached' => array(
        'library' => array(
          'vuepage/vue',
          'vuepage/bootstrap',
          'vuepage/axios',
          'vuepage/vuetable-2',
          'vuepage/vue_report',
          'vuepage/vue_table_js',
        )
      ),
    );

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function gameList() {
    // $name = 'time_one';
    // Timer::start($name);

    $VuepageContentGenerator = new VuepageContentGenerator();

    $build = array(
      '#children' => $VuepageContentGenerator->gameListContent(),
      '#attached' => array(
        'library' => array(
          'vuepage/vue',
          'vuepage/bootstrap',
          'vuepage/chart.js',
          'vuepage/axios',
          'vuepage/vue-chartjs',
          'vuepage/vue_game_list',
        )
      ),
    );

    // Timer::stop($name);
    // dpm(Timer::read($name) . 'ms');

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function newGameTable() {
    $VuepageTableGenerator = new VuepageTableGenerator();
    $markup = $VuepageTableGenerator->newGameTableContent();

    $build = array(
      '#type' => 'markup',
      '#header' => 'header',
      '#markup' => $markup,
      '#allowed_tags' => \Drupal::getContainer()->get('flexinfo.setting.service')->adminTag(),
    );

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function d3ChartPageContent() {
    $output = '
      <div class="container d3-js-example-wrapper">
        <d3-chart-wrapper>
        </d3-chart-wrapper>
        <div id="appPage">
          <h5>D3 JS Example</h5>
          <br />
        </div>
      </div>
    ';

    return $output;
  }

  /**
   *
   */
  public function d3ChartPage() {
    $content = $this->d3ChartPageContent();

    $build = array(
      '#children' => $content,
      '#attached' => array(
        'library' => array(
          'vuepage/d3.js',
          'vuepage/d3_js_chart_controller',
        )
      ),
    );

    return $build;
  }

}
