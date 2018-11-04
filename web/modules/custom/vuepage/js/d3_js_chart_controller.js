/**
 *
 D3 JS 一般步骤为：
 1.创建生成器
 2.转化数据
 3.绘制
 */

// 第一步，创建一个arc生成器。
var arc = d3.arc();

// 第二步，转换数据。
// 原始数据
// 存在一个对象之中，假设我们要接受后台的数据，接受了直接放在对象中也很方便。
var myData = {
  innerRadius: 80,//内半径，如果要画圆，设为0
  outerRadius: 100,//外半径
  startAngle: 0,//起始角度，此处使用弧度表示
  endAngle: 2*Math.PI//结束角度
};

// 数据转化
var outData = arc(myData);
// 如果想查看转换之后的数据，可以添加一个alert方法进行查看。
// alert(outData);


// 第三步，绘制
// 使用d3.js选择器选择一个节点，插入svg元素
 var svg = d3.select("d3-chart-wrapper")       // 选择"d3-chart-wrapper" tag
             .append("svg")        // 添加svg节点
             .attr("width", 400)   // 设置svg节点的宽度
             .attr("height", 400); // 设置高度

// 在svg中绘制
svg.append("g")//添加g元素
   .attr("transform", "translate(" + (400 / 2) + "," + (400 / 2) + ")")  // 设置图像在svg中的位置
   .append("path")//添加路径元素
   .attr("fill", "#f87979")//填充颜色，黑色
   .attr("d", outData);//加入转化后的数据
