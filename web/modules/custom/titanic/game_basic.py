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

### 2) 数据信息总览：
print("# Train Data Info")
jsonDataDf.info()
print("")


## 观察前几行的源数据：
## sns.set_style('whitegrid')

# print("# Train Data Head Teaser")
# print(jsonDataDf.head(30))

### 单变量分析, 绘制直方图
print("# 3 1 0 proportion")
print(jsonDataDf['Result'].value_counts(normalize = True))
print("")
# jsonDataDf['Result'].value_counts(normalize = True).plot(kind = "bar", alpha = 0.5)
# plt.show()

# sns.distplot(jsonDataDf['Result'].astype(int), kde = False)
# plt.show()

### 3) Plot
# jsonDataDf['Result'].value_counts().plot.pie(autopct = '%1.2f%%')
# plt.show()

# jsonDataDf[['Result', 'Tags']].groupby(['Result']).mean().plot.bar()
# plt.show()


### 4) 特征选择： 相关性矩阵
correlationDF = pd.DataFrame(jsonDataDf[
  ['ini_draw', 'ini_loss', 'ini_win', 'Result']
])

correlationResult = correlationDF.astype(float).corr()
# print(correlationResult)
# print(correlationResult['Result'].sort_values(ascending = False))

## 特征间相关性分析 生成特征之间的关联图
# colormap = plt.cm.viridis
# plt.figure(figsize = (10, 8))
# plt.title('Pearson Correlation of Features', y = 1.05, size = 12)
# sns.heatmap(correlationResult, linewidths = 0.1, vmax = 1.0, square = True, cmap = colormap, linecolor = 'white', annot = True)
# plt.show()



exit()


### 观察前几行的源数据：
# sns.set_style('whitegrid')
# print("# X_train Data Head Teaser")
# print(y_train.head(10))

### print model
# print(y_predict)
# print(y_test.describe())
