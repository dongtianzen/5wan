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
        <div id="appPage">
          <h5>Bootstrap Vue Example</h5>
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

    return $content;
  }

  /**
   * {@inheritdoc}
   */
  public function vuetable() {
    $content = '
      <h3 class="vue-title">Vuetable-2-bootstrap - https://codepen.io/ratiw/pen/GmJayw</h3>
      <div id="app">
        <div id="table-wrapper" class="ui container">
          <h2>
            <strong>Vuetable-2</strong>
            <span>with Bootstrap 3</span>
          </h2>

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
    $content = $this->vuetable();

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

  /**
   * {@inheritdoc}
   * @see https://vuejs.org/v2/examples/grid-component.html
   */
  public function gameListContent() {
    $content = '
      <script type="text/x-template" id="grid-template">
        <table>
          <thead>
            <tr>
              {{filteredTotal}}
            </tr>
            <tr>
              <th v-for="key in columns"
                @click="sortBy(key)"
                :class="{ active: sortKey == key }">
                {{ key | capitalize }}
                <span class="arrow" :class="sortOrders[key] > 0 ? \'asc\' : \'dsc\'">
                </span>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="entry in filteredData">
              <td v-for="key in columns">
                {{entry[key]}}
              </td>
            </tr>
          </tbody>
        </table>
      </script>

      <!-- <h3 class="vue-title">Grid Component Example - </h3> -->
      <div id="demo">
        <div>
          <span class="float-right" style="float:right;">
            Total is {{totalRow}}
          </span>
          <form id="search">
            Search <input name="query" v-model="searchQuery">
          </form>
        </div>

        <demo-grid
          :data="gridData"
          :columns="gridColumns"
          :filter-key="searchQuery"
        >
        </demo-grid>
      </div>
    ';

    return $content;
  }

  /**
   * {@inheritdoc}
   */
  public function gameList() {
    $name = 'time_one';
    Timer::start($name);

    $content = $this->gameListContent();

    $build = array(
      '#children' => $content,
      '#attached' => array(
        'library' => array(
          'vuepage/vue',
          'vuepage/babel-polyfill',
          'vuepage/bootstrap',
          'vuepage/bootstrap-vue',
          'vuepage/axios',
          'vuepage/vue_game_list',
        )
      ),
    );

    Timer::stop($name);
    // dpm(Timer::read($name) . 'ms');

    return $build;
  }

}
