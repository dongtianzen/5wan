"""
python3 web/modules/custom/titanic/game_outier.py
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

jsonDataDf['ave_win'] = jsonDataDf['ave_win'].astype(float)
jsonDataDf['ave_draw'] = jsonDataDf['ave_draw'].astype(float)
jsonDataDf['ave_loss'] = jsonDataDf['ave_loss'].astype(float)
jsonDataDf['Result'] = jsonDataDf['Result'].astype(int)

### 随机选取
# jsonDataDf = jsonDataDf[(jsonDataDf['tags'] == "法甲") | (jsonDataDf['tags'] == "法乙")]
# jsonDataDf = jsonDataDf[jsonDataDf['ave_loss'] < 2.6]

# jsonDataDf = jsonDataDf[jsonDataDf['ave_loss'] > 4.8]
# jsonDataDf = jsonDataDf.sample(n = 500)


### 2) 数据信息总览：
print("# Train Data Info")
jsonDataDf.info()
print(jsonDataDf)
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

## 个数分布
# sns.distplot(jsonDataDf['Result'], bins = 6, kde = False)
# plt.show()


### 4) 两个特征的关系，两个变量之间的分布关系
### 散点图

# sns.jointplot(x = 'ave_win', y = 'ave_loss', data = jsonDataDf)
# plt.show()


### 1) 回归分析, 线性关系的可视化

### 散点图
sns.lmplot(x = 'ave_win', y = 'ave_loss', data = jsonDataDf, hue = 'Result', aspect = 10/6.18, legend_out = False)
plt.show()



exit()
