!function(t){var e={};function a(r){if(e[r])return e[r].exports;var l=e[r]={i:r,l:!1,exports:{}};return t[r].call(l.exports,l,l.exports,a),l.l=!0,l.exports}a.m=t,a.c=e,a.d=function(t,e,r){a.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:r})},a.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},a.t=function(t,e){if(1&e&&(t=a(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(a.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var l in t)a.d(r,l,function(e){return t[e]}.bind(null,l));return r},a.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return a.d(e,"a",e),e},a.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},a.p="",a(a.s=0)}([function(t,e,a){var r=a(1),l={ave_win:r.value.default_ave_win,ave_draw:r.value.default_ave_draw,ave_loss:r.value.default_ave_loss,diff_win:r.value.default_diff_win,diff_draw:r.value.default_ave_draw,diff_loss:r.value.default_ave_loss,tags:r.value.default_tags,home:r.value.default_home,away:r.value.default_away};Vue.component("line-chart",{extends:VueChartJs.Bubble,data:()=>({chartDataSetSource:[{label:"Data One",backgroundColor:"#f87979",data:[{x:3.2,y:1.72,r:10},{x:2.2,y:2.12,r:10}]},{label:"Data two",backgroundColor:"#7c89fb",data:[{x:1.62,y:2.5,r:8}]}],options:{tooltips:{enabled:!0,callbacks:{label:function(t,e){return console.log(e),t.yLabel+"£"}}}}}),mounted(){axios.get("http://localhost:8888/5wan/web/dashpage/game/chart/json",{params:l}).then(t=>{console.log(t.request.responseURL),this.options={tooltips:{callbacks:{label:function(t,e){return t.yLabel+" rmb"}}}},this.chartDataSetSource=t.data.chartDataSetSource,this.renderChart({datasets:this.chartDataSetSource,options:this.options},{responsive:!0,maintainAspectRatio:!1})})}}),Vue.component("chartjs-scatter-chart",{extends:VueChartJs.Bubble,data:()=>({chartDataSetSource:[{label:"Data One",backgroundColor:"#f87979",data:[{x:3.2,y:1.72,r:10},{x:2.2,y:2.12,r:10}]},{label:"Data two",backgroundColor:"#7c89fb",data:[{x:1.62,y:2.5,r:8}]}],options:{tooltips:{enabled:!0,callbacks:{label:function(t,e){return console.log(e),t.yLabel+"£"}}}}}),mounted(){axios.get("http://localhost:8888/5wan/web/dashpage/game/chart/json",{params:l}).then(t=>{console.log(t.request.responseURL),this.options={tooltips:{callbacks:{label:function(t,e){return t.yLabel+" rmb"}}}},this.chartDataSetSource=t.data.chartDataSetSourceTwo,this.renderChart({datasets:this.chartDataSetSource,options:this.options},{responsive:!0,maintainAspectRatio:!1})})}});new Vue({el:".appchartjs",data:{message:"Game List Chart title - Hello World",scatterChartTitle:"x => Draw / Loss, y => Win"}});Vue.component("game-list-grid-tag",{template:"#grid-template",props:{data:Array,columns:Array,filterKey:String},data:function(){var t={};return this.columns.forEach(function(e){t[e]=1}),{sortKey:"",sortOrders:t,filteredTotal:0}},computed:{filteredData:function(){var t=this.sortKey,e=this.filterKey&&this.filterKey.toLowerCase(),a=this.sortOrders[t]||1,r=this.data;if(e){r=r.filter(function(t){return Object.keys(t).some(function(a){return String(t[a]).toLowerCase().indexOf(e)>-1})});for(var l=0,o=0,n=0,s=0;s<r.length;s++)"3"==r[s].Result&&l++,"1"==r[s].Result&&o++,"0"==r[s].Result&&n++;this.filteredTotal="-Filter is  "+r.length+",  Win "+l+" - "+100*(l/r.length).toFixed(3)+"%,  Draw "+o+",  Loss "+n}return t&&(r=r.slice().sort(function(e,r){return((e=e[t])===(r=r[t])?0:e>r?1:-1)*a})),r}},filters:{capitalize:function(t){return t.charAt(0).toUpperCase()+t.slice(1)}},methods:{sortBy:function(t){this.sortKey=t,this.sortOrders[t]=-1*this.sortOrders[t]}}});new Vue({el:"#game-list-grid-wrapper",data:()=>({searchQuery:"",gridColumns:["Date","Tags","Home","Away","Win","Draw","Loss","GoalH","GoalA","Num","Result"],gridData:[{name:"Samle tbody",power:7e3},{name:"Jet Li",power:8e3}],totalRow:0}),mounted(){axios.get("http://localhost:8888/5wan/web/dashpage/game/list/json",{params:l}).then(t=>{this.gridColumns=t.data.gridColumns,this.gridData=t.data.gridData,this.totalRow=this.gridData.length;for(var e=0,a=0,r=0,l=0;l<this.gridData.length;l++)"3"==this.gridData[l].Result&&e++,"1"==this.gridData[l].Result&&a++,"0"==this.gridData[l].Result&&r++;this.totalRow=this.gridData.length+",  Win "+e+" - "+100*(e/this.gridData.length).toFixed(3)+"%,  Draw "+a+",  Loss "+r})}})},function(t,e){var a={value:{default_ave_win:null,default_ave_draw:null,default_ave_loss:null,default_diff_win:null,default_diff_draw:null,default_diff_loss:null,default_tags:null,default_home:null,default_away:null}};a.value.default_ave_win=1.97,a.value.default_diff_win=.05,a.value.default_ave_draw=3.39,a.value.default_diff_draw=.1,a.value.default_ave_loss=4.05,a.value.default_diff_loss=.1,a.value.default_tags=["英超","英超"],a.value.default_home="水晶宫",a.value.default_away="南安普",t.exports=a}]);