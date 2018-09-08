"""
python3 web/modules/custom/titanic/5wan_game.py
因为读入数据有中文，在sublime text内运行有问题，需要到命令行运行
"""

# -*- coding: utf-8 -*-
import json
import numpy as np
import pandas as pd
import seaborn as sns
import urllib.request

import matplotlib.pyplot as plt

from pandas.io.json import json_normalize


# def function read json
def readJsonDecode(urlPath):
  with urllib.request.urlopen(urlPath) as url:
    output = json.loads(url.read().decode('utf-8'))

  return output


### 1) 读入数据, 将json串解析为DataFrame
pathUrl = 'http://localhost:8888/5wan/web/dashpage/game/list/json?ave_win=5.76'
pathUrl = 'http://localhost:8888/5wan/web/modules/custom/titanic/src/5wan_game_train.json'
trainData = readJsonDecode(pathUrl)
trainDf = json_normalize(trainData['gridData'])

### 2) 数据信息总览：
print("# Train Data Info")
trainDf.info()
print("")


## 观察前几行的源数据：
## sns.set_style('whitegrid')

# print("# Train Data Head Teaser")
# print(trainDf.head(30))

### 3)
# trainDf['Result'].value_counts().plot.pie(autopct = '%1.2f%%')

# trainDf[['Result', 'Tags']].groupby(['Result']).mean().plot.bar()
# plt.show()


### 4) 特征选择： 相关性矩阵
correlationDF = pd.DataFrame(trainDf[
  ['Draw', 'Loss', 'Win', 'Result']
])

correlationResult = correlationDF.astype(float).corr()
print(correlationResult)
print(correlationResult['Result'].sort_values(ascending = False))

## 特征间相关性分析 生成特征之间的关联图
colormap = plt.cm.viridis
plt.figure(figsize = (10, 8))
plt.title('Pearson Correlation of Features', y = 1.05, size = 12)
sns.heatmap(correlationResult, linewidths = 0.1, vmax = 1.0, square = True, cmap = colormap, linecolor = 'white', annot = True)
plt.show()


exit()

