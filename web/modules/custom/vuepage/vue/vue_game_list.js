/**
 * @to vue-chartjs v3 to draw line chart
 */
Vue.component('line-chart', {
  extends: VueChartJs.Bubble,
  mounted () {
    this.renderChart({
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label: 'Data One',
          backgroundColor: '#f87979',
          data: [
            {
              x: 30,
              y: 17,
              r: 10
            },
            {
              x: 20,
              y: 12,
              r: 10
            }
          ]
        },
        {
          label: 'Data two',
          backgroundColor: '#7c89fb',
          data: [
            {
              x: 16,
              y: 20,
              r: 8
            }
          ]
        }
      ]
    }, {responsive: true, maintainAspectRatio: false})
  }
})

/**
 *
 */
var vm = new Vue({
  el: '.appchartjs',
  data: {
    message: 'Chart title - Hello World'
  }
})

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

        this.filteredTotal = data.length
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
        params: {
          ave_win:   2.76,
          diff_win: 0.05,
          tags: ['英冠', '英甲'],
          // ave_draw:  3.28,
          // diff_draw: 0.1,
          // ave_loss:  2.25,
          // diff_loss: 0.05,
        }
      }
    )
    .then(
      response => {
        // JSON responses are automatically parsed.
        this.gridColumns = response.data.gridColumns,
        this.gridData = response.data.gridData
        this.totalRow = this.gridData.length
      }
    )
  }
})
