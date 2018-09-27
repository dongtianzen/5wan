/**
 *
 */
var NewGame = require('./new_game_value.js');

var pathArg = drupalSettings.path.currentPath.split('/');
if (pathArg[1] == 'game' && pathArg[2] == 'info' ) {

  axios.get(
    'http://localhost:8888/5wan/web/sites/default/files/json/5wan/currentGameList.json',
  )
  .then(
    response => {
      var jsonData = response.data

      if (jsonData[pathArg[3]] != undefined) {
        var row = jsonData[pathArg[3]];
        NewGame.value.default_ave_win  = row['ave_win'];
        NewGame.value.default_ave_draw = row['ave_draw'];
        NewGame.value.default_ave_loss = row['ave_loss'];

        NewGame.value.default_ini_win  = row['ini_win'];
        NewGame.value.default_ini_draw = row['ini_draw'];
        NewGame.value.default_ini_loss = row['ini_loss'];

        NewGame.value.default_name_home = row['name_home'];
        NewGame.value.default_name_away = row['name_away'];
        NewGame.value.default_tags = [row['tags']];

        NewGame.value.default_diff_win = 0.15;
        NewGame.value.default_diff_draw = 0.1;
        NewGame.value.default_diff_loss = 0.2;

        console.log(346688);
      }
      else {
        console.log(522237);
      }
    }
  )
}


console.log(44455);
/**
 *
 */
var default_ave_win  = NewGame.value.default_ave_win
var default_ave_draw = NewGame.value.default_ave_draw
var default_ave_loss = NewGame.value.default_ave_loss

var default_ini_win  = NewGame.value.default_ini_win
var default_ini_draw = NewGame.value.default_ini_draw
var default_ini_loss = NewGame.value.default_ini_loss

var default_diff_win  = NewGame.value.default_diff_win
var default_diff_draw = NewGame.value.default_ini_draw
var default_diff_loss = NewGame.value.default_ini_loss

var default_tags = NewGame.value.default_tags
var default_name_home = NewGame.value.default_name_home
var default_name_away = NewGame.value.default_name_away

var query_params = {
  ave_win:  default_ave_win,
  ave_draw: default_ave_draw,
  ave_loss: default_ave_loss,
  ini_win:  default_ini_win,
  ini_draw: default_ini_draw,
  ini_loss: default_ini_loss,
  diff_win:  default_diff_win,
  diff_draw: default_diff_draw,
  diff_loss: default_diff_loss,
  tags: default_tags,
  home: default_name_home,
  away: default_name_away,
}

/**
 * @to vue-chartjs v3 to draw line chart
 */
Vue.component('chartjs-chart-one', {
  extends: VueChartJs.Bubble,
  data () {
    return {
      chartDataSetSourceOne: [    // dataset sample format
        {
          label: 'Data One',
          backgroundColor: '#f87979',
          data: [
            {
              x: 3.20,
              y: 1.72,
              r: 10
            },
            {
              x: 2.20,
              y: 2.12,
              r: 10
            }
          ]
        },
        {
          label: 'Data two',
          backgroundColor: '#7c89fb',
          data: [
            {
              x: 1.62,
              y: 2.50,
              r: 8
            }
          ]
        }
      ],
      options: {
        tooltips: {
          enabled: true,
          callbacks: {
            label:function (tooltipItems, data) {
              console.log(data)
              return tooltipItems.yLabel + '£'
            }
          }
        }
      }
    }
  },
  mounted () {
    axios.get(
      'http://localhost:8888/5wan/web/dashpage/game/chart/json',
      {
        params: query_params
      }
    )
    .then(
      response => {
        console.log(response.request.responseURL)

        this.options = {
          tooltips: {
            callbacks: {
              label: function(tooltipItems, data) {
                return tooltipItems.yLabel + ' rmb';
              }
            }
          }
        }

        // JSON responses are automatically parsed.
        this.chartDataSetSourceOne = response.data.chartDataSetSourceOne

        this.renderChart({
          datasets: this.chartDataSetSourceOne,
          options: this.options
        }, {responsive: true, maintainAspectRatio: false})
      }
    )
  }
})

/**
 * @to vue-chartjs v3 to draw scatter chart
 */
Vue.component('chartjs-chart-two', {
  extends: VueChartJs.Bubble,
  data () {
    return {
      chartDataSetSourceTwo: [    // dataset sample format
        {
          label: 'Data One',
          backgroundColor: '#f87979',
          data: [
            {
              x: 3.20,
              y: 1.72,
              r: 10
            },
            {
              x: 2.20,
              y: 2.12,
              r: 10
            }
          ]
        },
        {
          label: 'Data two',
          backgroundColor: '#7c89fb',
          data: [
            {
              x: 1.62,
              y: 2.50,
              r: 8
            }
          ]
        }
      ],
      options: {
        tooltips: {
          enabled: true,
          callbacks: {
            label:function (tooltipItems, data) {
              console.log(data)
              return tooltipItems.yLabel + '£'
            }
          }
        }
      }
    }
  },
  mounted () {
    axios.get(
      'http://localhost:8888/5wan/web/dashpage/game/chart/json',
      {
        params: query_params
      }
    )
    .then(
      response => {
        console.log(response.request.responseURL)

        this.options = {
          tooltips: {
            callbacks: {
              label: function(tooltipItems, data) {
                return tooltipItems.yLabel + ' rmb';
              }
            }
          }
        }

        // JSON responses are automatically parsed.
        this.chartDataSetSourceTwo = response.data.chartDataSetSourceTwo

        this.renderChart({
          datasets: this.chartDataSetSourceTwo,
          options: this.options
        }, {responsive: true, maintainAspectRatio: false})
      }
    )
  }
})

/**
 * @to vue-chartjs v3 to draw scatter chart
 */
Vue.component('chartjs-chart-six', {
  extends: VueChartJs.Bubble,
  data () {
    return {
      chartDataSetSourceSix: [    // dataset sample format
        {
          label: 'Data One',
          backgroundColor: '#f87979',
          data: [
            {
              x: 3.20,
              y: 1.72,
              r: 10
            },
            {
              x: 2.20,
              y: 2.12,
              r: 10
            }
          ]
        },
        {
          label: 'Data two',
          backgroundColor: '#7c89fb',
          data: [
            {
              x: 1.62,
              y: 2.50,
              r: 8
            }
          ]
        }
      ],
      options: {
        tooltips: {
          enabled: true,
          callbacks: {
            label:function (tooltipItems, data) {
              console.log(data)
              return tooltipItems.yLabel + '£'
            }
          }
        }
      }
    }
  },
  mounted () {
    axios.get(
      'http://localhost:8888/5wan/web/dashpage/game/chart/json',
      {
        params: query_params
      }
    )
    .then(
      response => {
        console.log(response.request.responseURL)

        this.options = {
          tooltips: {
            callbacks: {
              label: function(tooltipItems, data) {
                return tooltipItems.yLabel + ' rmb';
              }
            }
          }
        }

        // JSON responses are automatically parsed.
        this.chartDataSetSourceSix = response.data.chartDataSetSourceSix
        this.renderChart({
          datasets: this.chartDataSetSourceSix,
          options: this.options
        }, {responsive: true, maintainAspectRatio: false})
      }
    )
  }
})

/**
 *
 */
var vm = new Vue({
  el: '.appchartjs',
  data: {
    chartTitleOne: 'X => Draw, Y => Loss, R => min(win, draw, loss) - min(ini_win, ini_draw, int_loss)',
    chartTitleTwo: 'X => Draw / Loss, Y => Win, R => min(win, draw, loss) - min(ini_win, ini_draw, int_loss)',
    chartTitleSix: 'X => Win - ini, Y => Loss - ini, R => Draw - ini'
  }
})

/** - - - grid table - - - - - - - - - - - - - */
/**
 * for game list table
 */
Vue.component('game-list-grid-tag', {
  template: '#grid-template',
  props: {
    data: Array,
    columns: Array,
    filterKey: String
  },
  data: function () {
    var sortOrders = {}
    this.columns.forEach(function (key) {
      sortOrders[key] = 1
    })
    return {
      sortKey: '',
      sortOrders: sortOrders,
      filteredTotal: 0,
    }
  },
  computed: {
    filteredData: function () {
      var sortKey = this.sortKey
      var filterKey = this.filterKey && this.filterKey.toLowerCase()
      var order = this.sortOrders[sortKey] || 1
      var data = this.data

      if (filterKey) {
        data = data.filter(function (row) {
          return Object.keys(row).some(function (key) {
            return String(row[key]).toLowerCase().indexOf(filterKey) > -1
          })
        })

        var filterWinNum = 0
        var filterDrawNum = 0
        var filterLossNum = 0
        for (var i = 0; i < data.length; i++) {
          if (data[i].Result == '3') {
            filterWinNum++
          }
          if (data[i].Result == '1') {
            filterDrawNum++
          }
          if (data[i].Result == '0') {
            filterLossNum++
          }
        }

        this.filteredTotal = '-Filter is  ' + data.length
          + ',  Win ' + filterWinNum + ' - ' + (filterWinNum / data.length).toFixed(3) * 100 + '%'
          + ',  Draw ' + filterDrawNum
          + ',  Loss ' + filterLossNum
      }

      if (sortKey) {
        data = data.slice().sort(function (a, b) {
          a = a[sortKey]
          b = b[sortKey]
          return (a === b ? 0 : a > b ? 1 : -1) * order
        })
      }

      return data
    }
  },
  filters: {
    capitalize: function (str) {
      return str.charAt(0).toUpperCase() + str.slice(1)
    }
  },
  methods: {
    sortBy: function (key) {
      this.sortKey = key
      this.sortOrders[key] = this.sortOrders[key] * -1
    }
  }
})

/**
 * bootstrap the demo data
 *
  var demo = new Vue({
    el: '#demo',
    data: {
      searchQuery: '',
      gridColumns: ['name', 'power'],
      gridData: [
        { name: 'Chuck Norris', power: Infinity },
        { name: 'Bruce Lee', power: 9000 },
        { name: 'Jackie Chan', power: 7000 },
        { name: 'Jet Li', power: 8000 }
      ]
    }
  })
 */

// the demo
var demo = new Vue({
  el: '#game-list-grid-wrapper',
  data () {
    return {
      searchQuery: '',
      gridColumns: [
        'Date',
        'Tags',
        'Home',
        'Away',
        'Win',
        'Draw',
        'Loss',
        'GoalH',
        'GoalA',
        'Num',
        'Result'
      ],
      gridData: [
        { name: 'Samle tbody', power: 7000 },
        { name: 'Jet Li', power: 8000 }
      ],
      totalRow: 0
    }
  },
  mounted () {
    axios.get(
      'http://localhost:8888/5wan/web/dashpage/game/list/json',
      {
        params: query_params
      }
    )
    .then(
      response => {
        // JSON responses are automatically parsed.
        this.gridColumns = response.data.gridColumns,
        this.gridData = response.data.gridData,
        this.totalRow = this.gridData.length

        var winNum = 0
        var drawNum = 0
        var lossNum = 0

        for (var i = 0; i < this.gridData.length; i++) {
          if (this.gridData[i].Result == '3') {
            winNum++
          }
          if (this.gridData[i].Result == '1') {
            drawNum++
          }
          if (this.gridData[i].Result == '0') {
            lossNum++
          }
        }

        this.totalRow = this.gridData.length
          + ',  Win ' + winNum + ' - ' + (winNum / this.gridData.length).toFixed(3) * 100 + '%'
          + ',  Draw ' + drawNum
          + ',  Loss ' + lossNum

      }
    )
  }
})
