"""
python3 web/modules/custom/titanic/game_outlier.py
因为读入数据有中文，在sublime text内运行有问题，需要到命令行运行
"""

# -*- coding: utf-8 -*-
import numpy as np
import pandas as pd
import seaborn as sns
import matplotlib.pyplot as plt
import matplotlib.gridspec as gridspec

from pandas.io.json import json_normalize

from game_json import GameJsonClass

# displaying entire dataframes print all column
pd.set_option('display.max_columns', None)

### 1) 读入数据, 将json串解析为DataFrame
pathUrl = 'http://localhost:8888/5wan/web/dashjson/game/fields/value?ave_win=2.86&diff_win=0.1&ave_loss=2.55&diff_loss=0.2'
pathUrl = 'http://localhost:8888/5wan/web/dashjson/game/fields/value?ave_win=1.97&diff_win=0.2'
pathUrl = 'http://localhost:8888/5wan/web/sites/default/files/titanic/src/ave_win_197.json'

jsonDataDf = GameJsonClass().getJsonFromDictContent(pathUrl)

jsonDataDf['ave_win'] = jsonDataDf['ave_win'].astype(float)
jsonDataDf['ave_draw'] = jsonDataDf['ave_draw'].astype(float)
jsonDataDf['ave_loss'] = jsonDataDf['ave_loss'].astype(float)

### 筛选
# jsonDataDf = jsonDataDf[(jsonDataDf['tags'] == "法甲") | (jsonDataDf['tags'] == "法乙")]
# jsonDataDf = jsonDataDf[jsonDataDf['ave_loss'] < 2.6]
# jsonDataDf = jsonDataDf[jsonDataDf['ave_loss'] > 4.8]


### 2) 数据信息总览：
print("# Train Data Info")
jsonDataDf.info()


### 加result
jsonDataDf['result'] = 1
jsonDataDf.loc[jsonDataDf['goal_home'] > jsonDataDf['goal_away'], "result"] = 3
jsonDataDf.loc[jsonDataDf['goal_home'] < jsonDataDf['goal_away'], "result"] = 0


### 排序Dataframe
# print(jsonDataDf.sort_values(by='ave_loss'))


## 观察前几行的源数据：
## 因为读入数据有中文，在sublime text内运行有问题，需要到命令行运行
# sns.set_style('whitegrid')
# print("# Train Data Head Teaser")
# print(jsonDataDf.head(30))

### 3) 单变量分析, 打印百分比
### 绘制直方图
print("# 3 1 0 proportion")
print(jsonDataDf['result'].value_counts(normalize = True))
print("")


### 0) 回归分析, 线性关系的可视化
###    两个特征的关系，两个变量之间的分布关系

### 散点图
jsonDataDf['win_divide_loss'] = jsonDataDf['ave_win'] / jsonDataDf['ave_loss']
jsonDataDf['win_divide_draw'] = jsonDataDf['ave_win'] / jsonDataDf['ave_draw']

### 3个变量对比
fig, (ax1, ax2, ax3) = plt.subplots(ncols=3, sharey=True)
sns.scatterplot(x = 'ave_win', y = 'ave_loss', data = jsonDataDf, hue = 'result', sizes=(200, 300), legend="full", ax=ax1, palette="Accent")
sns.scatterplot(x = 'ave_win', y = 'ave_draw', data = jsonDataDf, hue = 'result', sizes=(200, 300), legend="full", ax=ax2, palette="Accent")
sns.scatterplot(x = 'ave_draw', y = 'ave_loss', data = jsonDataDf, hue = 'result', sizes=(200, 300), legend="full", ax=ax3, palette="Accent")


### 分组散点图
# sns.pairplot(jsonDataDf, x_vars=["ave_win", "ave_draw", "ave_loss"], y_vars=["win_divide_draw"],
#              size=5, aspect=.8, kind="reg", hue="result", palette="husl");

###
# sns.lmplot(x = 'ave_win', y = 'ave_loss', data = jsonDataDf, hue = 'result', aspect = 10/6.18, legend_out = False)
# sns.lmplot(x = 'win_divide_loss', y = 'win_divide_draw', data = jsonDataDf, hue = 'result', aspect = 10/6.18, legend_out = False)



plt.show()

exit()
