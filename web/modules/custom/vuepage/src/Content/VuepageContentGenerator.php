<?php

/**
 * @file
 */
namespace Drupal\vuepage\Content;

use Drupal\Core\Controller\ControllerBase;

/**
 * An example controller.
 $VuepageContentGenerator = new VuepageContentGenerator();
 $VuepageContentGenerator->demoPage();
 */
class VuepageContentGenerator extends ControllerBase {


  /**
   * {@inheritdoc}
   * @see https://vuejs.org/v2/examples/grid-component.html
   */
  public function gameListContent() {
    $output = NULL;
    $output .= '<div class="game-list-content-wrapper" style="margin-left:12px; margin-right:12px;">';
      $output .= $this->gameListContentGridScript();
      $output .= $this->gameListContentGrid();
      $output .= $this->gameListContentChartJs();
    $output .= '</div>';

    return $output;
  }

  /**
   *
   */
  public function gameListContentChartJs() {
    $output = '
      <div class="appchartjs">
          {{ chartTitleOne }}
        <div class="margin-top-12">
          <chartjs-chart-one></chartjs-chart-one>
        </div>
          {{ chartTitleTwo }}
        <div class="margin-top-12">
          <chartjs-chart-two></chartjs-chart-two>
        </div>
          {{ chartTitleSix }}
        <div class="margin-top-12">
          <chartjs-chart-six></chartjs-chart-six>
        </div>
      </div>
    ';

    return $output;
  }

  /**
   * table
   */
  public function gameListContentGrid() {
    // <!-- <h3 class="vue-title">Grid Component Example - </h3> -->
    $output = '
      <div id="game-list-grid-wrapper">
        <div class="game-list-grid-wrapper" >
          <span class="float-right" style="float:right; font-family:Verdana">
            Total is {{totalRow}}
          </span>
          <form id="search" class="game-list-grid-top-search">
            Search <input name="query" v-model="searchQuery">
          </form>
        </div>

        <game-list-grid-tag
          :data="gridData"
          :columns="gridColumns"
          :filter-key="searchQuery"
        >
        </game-list-grid-tag>
      </div>
    ';

    return $output;
  }

  /**
   */
  public function gameListContentGridScript() {
    $output = '
      <script type="text/x-template" id="grid-template">
        <table class="table table-striped table-hover">
          <thead>
            <tr class="game-list-grid-thead-filter-total-number">
              <td colspan="8">
              </td>
              <td colspan="3" style="font-size:14px; font-family:Verdana">
                {{filteredTotal}}
              </td>
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
    ';

    return $output;
  }

}
