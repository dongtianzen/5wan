/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "../modules/custom/vuepage/vue/vue_game_list.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "../modules/custom/vuepage/vue/vue_game_list.js":
/*!******************************************************!*\
  !*** ../modules/custom/vuepage/vue/vue_game_list.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("/**\n *\n label: function(t, d) {\n   return d.datasets[t.datasetIndex].label +\n     ': (Day:' + t.xLabel + ', Total:' + t.yLabel + ')';\n }\n */\n\n// var NewGame = require('./vue/new_game_valuew.js');\n\nvar default_ave_win  = 2.03\nvar default_ave_draw = null\nvar default_ave_loss = null\n\nvar default_diff_win  = 0.03\nvar default_diff_draw = null\nvar default_diff_loss = null\n\nvar default_tags = ['挪超']\nvar default_home = '博德闪耀'\nvar default_away = '奥德'\n\nvar query_params = {\n  ave_win:  default_ave_win,\n  ave_draw: default_ave_draw,\n  ave_loss: default_ave_loss,\n  diff_win:  default_diff_win,\n  diff_draw: default_diff_draw,\n  diff_loss: default_diff_loss,\n  tags: default_tags,\n  home: default_home,\n  away: default_away,\n}\n\n/**\n * @to vue-chartjs v3 to draw line chart\n */\nVue.component('line-chart', {\n  extends: VueChartJs.Bubble,\n  data () {\n    return {\n      chartDataSetSource: [    // dataset sample format\n        {\n          label: 'Data One',\n          backgroundColor: '#f87979',\n          data: [\n            {\n              x: 3.20,\n              y: 1.72,\n              r: 10\n            },\n            {\n              x: 2.20,\n              y: 2.12,\n              r: 10\n            }\n          ]\n        },\n        {\n          label: 'Data two',\n          backgroundColor: '#7c89fb',\n          data: [\n            {\n              x: 1.62,\n              y: 2.50,\n              r: 8\n            }\n          ]\n        }\n      ],\n      options: {\n        tooltips: {\n          enabled: true,\n          callbacks: {\n            label:function (tooltipItems, data) {\n              console.log(data)\n              return tooltipItems.yLabel + '£'\n            }\n          }\n        }\n      }\n    }\n  },\n  mounted () {\n    axios.get(\n      'http://localhost:8888/5wan/web/dashpage/game/chart/json',\n      {\n        params: query_params\n      }\n    )\n    .then(\n      response => {\n        console.log(response.request.responseURL)\n\n        this.options = {\n          tooltips: {\n            callbacks: {\n              label: function(tooltipItems, data) {\n                return tooltipItems.yLabel + ' rmb';\n              }\n            }\n          }\n        }\n\n        // JSON responses are automatically parsed.\n        this.chartDataSetSource = response.data.chartDataSetSource\n\n        this.renderChart({\n          datasets: this.chartDataSetSource,\n          options: this.options\n        }, {responsive: true, maintainAspectRatio: false})\n      }\n    )\n  }\n})\n\n/**\n *\n */\nvar vm = new Vue({\n  el: '.appchartjs',\n  data: {\n    message: 'Chart title - Hello World'\n  }\n})\n\n/** - - - grid table - - - - - - - - - - - - - */\n/**\n * for game list table\n */\nVue.component('game-list-grid-tag', {\n  template: '#grid-template',\n  props: {\n    data: Array,\n    columns: Array,\n    filterKey: String\n  },\n  data: function () {\n    var sortOrders = {}\n    this.columns.forEach(function (key) {\n      sortOrders[key] = 1\n    })\n    return {\n      sortKey: '',\n      sortOrders: sortOrders,\n      filteredTotal: 0,\n    }\n  },\n  computed: {\n    filteredData: function () {\n      var sortKey = this.sortKey\n      var filterKey = this.filterKey && this.filterKey.toLowerCase()\n      var order = this.sortOrders[sortKey] || 1\n      var data = this.data\n\n      if (filterKey) {\n        data = data.filter(function (row) {\n          return Object.keys(row).some(function (key) {\n            return String(row[key]).toLowerCase().indexOf(filterKey) > -1\n          })\n        })\n\n        var filterWinNum = 0\n        var filterDrawNum = 0\n        var filterLossNum = 0\n        for (var i = 0; i < data.length; i++) {\n          if (data[i].Result == '3') {\n            filterWinNum++\n          }\n          if (data[i].Result == '1') {\n            filterDrawNum++\n          }\n          if (data[i].Result == '0') {\n            filterLossNum++\n          }\n        }\n\n        this.filteredTotal = '-Filter is  ' + data.length\n          + ',  Win ' + filterWinNum + ' - ' + (filterWinNum / data.length).toFixed(3) * 100 + '%'\n          + ',  Draw ' + filterDrawNum\n          + ',  Loss ' + filterLossNum\n      }\n\n      if (sortKey) {\n        data = data.slice().sort(function (a, b) {\n          a = a[sortKey]\n          b = b[sortKey]\n          return (a === b ? 0 : a > b ? 1 : -1) * order\n        })\n      }\n\n      return data\n    }\n  },\n  filters: {\n    capitalize: function (str) {\n      return str.charAt(0).toUpperCase() + str.slice(1)\n    }\n  },\n  methods: {\n    sortBy: function (key) {\n      this.sortKey = key\n      this.sortOrders[key] = this.sortOrders[key] * -1\n    }\n  }\n})\n\n/**\n * bootstrap the demo data\n *\n  var demo = new Vue({\n    el: '#demo',\n    data: {\n      searchQuery: '',\n      gridColumns: ['name', 'power'],\n      gridData: [\n        { name: 'Chuck Norris', power: Infinity },\n        { name: 'Bruce Lee', power: 9000 },\n        { name: 'Jackie Chan', power: 7000 },\n        { name: 'Jet Li', power: 8000 }\n      ]\n    }\n  })\n */\n\n// the demo\nvar demo = new Vue({\n  el: '#game-list-grid-wrapper',\n  data () {\n    return {\n      searchQuery: '',\n      gridColumns: [\n        'Date',\n        'Tags',\n        'Home',\n        'Away',\n        'Win',\n        'Draw',\n        'Loss',\n        'GoalH',\n        'GoalA',\n        'Num',\n        'Result'\n      ],\n      gridData: [\n        { name: 'Samle tbody', power: 7000 },\n        { name: 'Jet Li', power: 8000 }\n      ],\n      totalRow: 0\n    }\n  },\n  mounted () {\n    axios.get(\n      'http://localhost:8888/5wan/web/dashpage/game/list/json',\n      {\n        params: query_params\n      }\n    )\n    .then(\n      response => {\n        // JSON responses are automatically parsed.\n        this.gridColumns = response.data.gridColumns,\n        this.gridData = response.data.gridData,\n        this.totalRow = this.gridData.length\n\n        var winNum = 0\n        var drawNum = 0\n        var lossNum = 0\n\n        for (var i = 0; i < this.gridData.length; i++) {\n          if (this.gridData[i].Result == '3') {\n            winNum++\n          }\n          if (this.gridData[i].Result == '1') {\n            drawNum++\n          }\n          if (this.gridData[i].Result == '0') {\n            lossNum++\n          }\n        }\n\n        this.totalRow = this.gridData.length\n          + ',  Win ' + winNum + ' - ' + (winNum / this.gridData.length).toFixed(3) * 100 + '%'\n          + ',  Draw ' + drawNum\n          + ',  Loss ' + lossNum\n\n      }\n    )\n  }\n})\n\n\n//# sourceURL=webpack:///../modules/custom/vuepage/vue/vue_game_list.js?");

/***/ })

/******/ });