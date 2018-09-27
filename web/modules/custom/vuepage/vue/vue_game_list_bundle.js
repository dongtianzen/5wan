!function(a){var e={};function t(l){if(e[l])return e[l].exports;var n=e[l]={i:l,l:!1,exports:{}};return a[l].call(n.exports,n,n.exports,t),n.l=!0,n.exports}t.m=a,t.c=e,t.d=function(a,e,l){t.o(a,e)||Object.defineProperty(a,e,{enumerable:!0,get:l})},t.r=function(a){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(a,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(a,"__esModule",{value:!0})},t.t=function(a,e){if(1&e&&(a=t(a)),8&e)return a;if(4&e&&"object"==typeof a&&a&&a.__esModule)return a;var l=Object.create(null);if(t.r(l),Object.defineProperty(l,"default",{enumerable:!0,value:a}),2&e&&"string"!=typeof a)for(var n in a)t.d(l,n,function(e){return a[e]}.bind(null,n));return l},t.n=function(a){var e=a&&a.__esModule?function(){return a.default}:function(){return a};return t.d(e,"a",e),e},t.o=function(a,e){return Object.prototype.hasOwnProperty.call(a,e)},t.p="",t(t.s=0)}([function(a,e,t){var l=t(1),n={ave_win:l.value.default_ave_win,ave_draw:l.value.default_ave_draw,ave_loss:l.value.default_ave_loss,ini_win:l.value.default_ini_win,ini_draw:l.value.default_ini_draw,ini_loss:l.value.default_ini_loss,diff_win:l.value.default_diff_win,diff_draw:l.value.default_ini_draw,diff_loss:l.value.default_ini_loss,tags:l.value.default_tags,home:l.value.default_name_home,away:l.value.default_name_away};Vue.component("chartjs-chart-one",{extends:VueChartJs.Bubble,data:()=>({chartDataSetSourceOne:[{label:"Data One",backgroundColor:"#f87979",data:[{x:3.2,y:1.72,r:10},{x:2.2,y:2.12,r:10}]},{label:"Data two",backgroundColor:"#7c89fb",data:[{x:1.62,y:2.5,r:8}]}],options:{tooltips:{enabled:!0,callbacks:{label:function(a,e){return console.log(e),a.yLabel+"£"}}}}}),mounted(){axios.get("http://localhost:8888/5wan/web/dashpage/game/chart/json",{params:n}).then(a=>{console.log(a.request.responseURL),this.options={tooltips:{callbacks:{label:function(a,e){return a.yLabel+" rmb"}}}},this.chartDataSetSourceOne=a.data.chartDataSetSourceOne,this.renderChart({datasets:this.chartDataSetSourceOne,options:this.options},{responsive:!0,maintainAspectRatio:!1})})}}),Vue.component("chartjs-chart-two",{extends:VueChartJs.Bubble,data:()=>({chartDataSetSourceTwo:[{label:"Data One",backgroundColor:"#f87979",data:[{x:3.2,y:1.72,r:10},{x:2.2,y:2.12,r:10}]},{label:"Data two",backgroundColor:"#7c89fb",data:[{x:1.62,y:2.5,r:8}]}],options:{tooltips:{enabled:!0,callbacks:{label:function(a,e){return console.log(e),a.yLabel+"£"}}}}}),mounted(){axios.get("http://localhost:8888/5wan/web/dashpage/game/chart/json",{params:n}).then(a=>{console.log(a.request.responseURL),this.options={tooltips:{callbacks:{label:function(a,e){return a.yLabel+" rmb"}}}},this.chartDataSetSourceTwo=a.data.chartDataSetSourceTwo,this.renderChart({datasets:this.chartDataSetSourceTwo,options:this.options},{responsive:!0,maintainAspectRatio:!1})})}}),Vue.component("chartjs-chart-six",{extends:VueChartJs.Bubble,data:()=>({chartDataSetSourceSix:[{label:"Data One",backgroundColor:"#f87979",data:[{x:3.2,y:1.72,r:10},{x:2.2,y:2.12,r:10}]},{label:"Data two",backgroundColor:"#7c89fb",data:[{x:1.62,y:2.5,r:8}]}],options:{tooltips:{enabled:!0,callbacks:{label:function(a,e){return console.log(e),a.yLabel+"£"}}}}}),mounted(){axios.get("http://localhost:8888/5wan/web/dashpage/game/chart/json",{params:n}).then(a=>{console.log(a.request.responseURL),this.options={tooltips:{callbacks:{label:function(a,e){return a.yLabel+" rmb"}}}},this.chartDataSetSourceSix=a.data.chartDataSetSourceSix,this.renderChart({datasets:this.chartDataSetSourceSix,options:this.options},{responsive:!0,maintainAspectRatio:!1})})}});new Vue({el:".appchartjs",data:{chartTitleOne:"X => Draw, Y => Loss, R => min(win, draw, loss) - min(ini_win, ini_draw, int_loss)",chartTitleTwo:"X => Draw / Loss, Y => Win, R => min(win, draw, loss) - min(ini_win, ini_draw, int_loss)",chartTitleSix:"X => Win - ini, Y => Loss - ini, R => Draw - ini"}});Vue.component("game-list-grid-tag",{template:"#grid-template",props:{data:Array,columns:Array,filterKey:String},data:function(){var a={};return this.columns.forEach(function(e){a[e]=1}),{sortKey:"",sortOrders:a,filteredTotal:0}},computed:{filteredData:function(){var a=this.sortKey,e=this.filterKey&&this.filterKey.toLowerCase(),t=this.sortOrders[a]||1,l=this.data;if(e){l=l.filter(function(a){return Object.keys(a).some(function(t){return String(a[t]).toLowerCase().indexOf(e)>-1})});for(var n=0,o=0,r=0,i=0;i<l.length;i++)"3"==l[i].Result&&n++,"1"==l[i].Result&&o++,"0"==l[i].Result&&r++;this.filteredTotal="-Filter is  "+l.length+",  Win "+n+" - "+100*(n/l.length).toFixed(3)+"%,  Draw "+o+",  Loss "+r}return a&&(l=l.slice().sort(function(e,l){return((e=e[a])===(l=l[a])?0:e>l?1:-1)*t})),l}},filters:{capitalize:function(a){return a.charAt(0).toUpperCase()+a.slice(1)}},methods:{sortBy:function(a){this.sortKey=a,this.sortOrders[a]=-1*this.sortOrders[a]}}});new Vue({el:"#game-list-grid-wrapper",data:()=>({searchQuery:"",gridColumns:["Date","Tags","Home","Away","Win","Draw","Loss","GoalH","GoalA","Num","Result"],gridData:[{name:"Samle tbody",power:7e3},{name:"Jet Li",power:8e3}],totalRow:0}),mounted(){axios.get("http://localhost:8888/5wan/web/dashpage/game/list/json",{params:n}).then(a=>{this.gridColumns=a.data.gridColumns,this.gridData=a.data.gridData,this.totalRow=this.gridData.length;for(var e=0,t=0,l=0,n=0;n<this.gridData.length;n++)"3"==this.gridData[n].Result&&e++,"1"==this.gridData[n].Result&&t++,"0"==this.gridData[n].Result&&l++;this.totalRow=this.gridData.length+",  Win "+e+" - "+100*(e/this.gridData.length).toFixed(3)+"%,  Draw "+t+",  Loss "+l})}})},function(a,e){var t={value:{default_ave_win:null,default_ave_draw:null,default_ave_loss:null,default_diff_win:null,default_diff_draw:null,default_diff_loss:null,default_tags:null,default_name_home:null,default_name_away:null}};t.value.default_ave_draw=4.05,t.value.default_ave_loss=1.81,t.value.default_ave_win=3.93,t.value.default_ini_draw=3.96,t.value.default_ini_loss=1.74,t.value.default_ini_win=4.19,t.value.default_name_away="皇家马德里",t.value.default_name_home="塞维利亚",t.value.default_tags=["西甲","西甲"],t.value.default_diff_win=.15,t.value.default_diff_draw=.1,t.value.default_diff_loss=.2;var l=drupalSettings.path.currentPath.split("/");"game"==l[1]&&"info"==l[2]&&axios.get("http://localhost:8888/5wan/web/sites/default/files/json/5wan/currentGameList.json").then(a=>{var e=a.data;if(void 0!=e[l[3]]){var n=e[l[3]];t.value.default_ave_win=n.ave_win,t.value.default_ave_draw=n.ave_draw,t.value.default_ave_loss=n.ave_loss,t.value.default_ini_win=n.ini_win,t.value.default_ini_draw=n.ini_draw,t.value.default_ini_loss=n.ini_loss,t.value.default_name_home=n.name_home,t.value.default_name_away=n.name_away,t.value.default_tags=[n.tags],t.value.default_diff_win=.15,t.value.default_diff_draw=.1,t.value.default_diff_loss=.2}else console.log(5222)}),a.exports=t}]);