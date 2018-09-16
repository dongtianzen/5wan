"""
python3 web/modules/custom/titanic/5wan_game.py
因为读入数据有中文，在sublime text内运行有问题，需要到命令行运行
"""

# -*- coding: utf-8 -*-
import numpy as np
import pandas as pd
import seaborn as sns

import matplotlib.pyplot as plt

from pandas.io.json import json_normalize

from game_json import GameJsonClass

### 1) 读入数据, 将json串解析为DataFrame
jsonDataDf = GameJsonClass().getJsonContent()


### 随机选取
jsonDataDf = jsonDataDf.sample(n = 500)


### 2) 数据信息总览：
print("# Train Data Info")
jsonDataDf.info()
print("")

## 排序打印Dataframe
# print(jsonDataDf['Result'].sort_values(ascending = False))

## 观察前几行的源数据：
## 因为读入数据有中文，在sublime text内运行有问题，需要到命令行运行
# sns.set_style('whitegrid')
# print("# Train Data Head Teaser")
# print(jsonDataDf.head(30))

### 3) 单变量分析,
### 绘制直方图
print("# 3 1 0 proportion")
print(jsonDataDf['Result'].value_counts(normalize = True))
print("")

jsonDataDf['ave_win'] = jsonDataDf['ave_win'].astype(float)
jsonDataDf['ave_loss'] = jsonDataDf['ave_loss'].astype(float)
jsonDataDf['Result'] = jsonDataDf['Result'].astype(int)

## ave_win - ini_win 正数为1, 负数为0
jsonDataDf['ave_ini_win'] = 0
jsonDataDf.loc[jsonDataDf['diff_win'] > 0, 'ave_ini_win'] = 1

## 百分比
# jsonDataDf['Result'].value_counts(normalize = True).plot(kind = "bar", alpha = 0.5)
# plt.show()

## Pie chart
# jsonDataDf['Result'].value_counts().plot.pie(autopct = '%1.2f%%')
# plt.show()

## 个数分布
# sns.distplot(jsonDataDf['Result'], bins = 6, kde = False)
# plt.show()


### 4) 两个特征的关系，两个变量之间的分布关系
### 散点图

# sns.jointplot(x = 'ave_win', y = 'ave_loss', data = jsonDataDf)
# plt.show()

## 用“hex”来展示出现频率，当数据量比较多的时候，散点堆积重叠
# sns.jointplot(x = 'ave_win', y = 'ave_loss', data = jsonDataDf, kind = "hex", color = "k")
# plt.show()


### 3) Pair Plot, 3 x 3 的plot 用来特征两两对比，对角线上是单变量直方图
# tempDF = pd.DataFrame(jsonDataDf[
#   ['ave_win', 'ave_loss', 'Result']
# ])
# sns.pairplot(tempDF)
# plt.show()

### 4) 分组图
# jsonDataDf[['Result', 'Tags']].groupby(['Result']).mean().plot.bar()
# plt.show()


### 5) 特征选择： 相关性矩阵
# # 特征间相关性分析 生成特征之间的关联图
# correlationResult = pd.DataFrame(jsonDataDf[
#   ['ave_win', 'ave_loss', 'Result']
# ])
# colormap = plt.cm.viridis
# plt.figure(figsize = (10, 8))
# plt.title('Pearson Correlation of Features', y = 1.05, size = 12)
# sns.heatmap(correlationResult, linewidths = 0.1, vmax = 1.0, square = True, cmap = colormap, linecolor = 'white', annot = True)
# plt.show()




### 1) 回归分析, 线性关系的可视化

### 散点图
# sns.lmplot(x = 'ave_win', y = 'ave_loss', data = jsonDataDf, hue = 'Result', aspect = 10/6.18, legend_out = False)
# plt.show()

### 盒图
# sns.set(rc={'figure.figsize':(10, 6.2)})
# sns.boxplot(x = 'Result', y = 'ave_win', hue = 'ave_ini_win', data = jsonDataDf)
# plt.show()

### 小提琴图
# sns.violinplot(x = 'Result', y = 'ave_win', hue = 'ave_ini_win', data = jsonDataDf)
# plt.show()
# sns.violinplot(x = 'Result', y = 'ave_win', hue = 'ave_ini_win', data = jsonDataDf, split = True)
# plt.show()

### 分类属性绘图
sns.barplot(x = 'Result', y = 'ave_win', hue = 'ave_ini_win', data = jsonDataDf)
plt.show()




exit()
