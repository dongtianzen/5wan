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
    output = json.loads(url.read().decode())

  return output


### 1) 读入数据, 将json串解析为DataFrame
pathUrl = 'http://localhost:8888/5wan/web/dashpage/game/list/json?ave_win=7.76'
trainData = readJsonDecode(pathUrl)
trainDf = df = json_normalize(trainData['gridData'])

### 2) 数据信息总览：
print("# Train Data Info")
trainDf.info()
print("")


## 观察前几行的源数据：
# sns.set_style('whitegrid')
# print("# Train Data Head Teaser")
# print(trainData.head())

### 3)
trainDf['Result'].value_counts().plot.pie(autopct = '%1.2f%%')

trainDf[['Result','Tags']].groupby(['Result']).mean().plot.bar()
plt.show()

exit()
