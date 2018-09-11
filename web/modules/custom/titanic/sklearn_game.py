"""
python3 web/modules/custom/titanic/sklearn_game.py
因为读入数据有中文，在sublime text内运行有问题，需要到命令行运行
"""

# -*- coding: utf-8 -*-
import json
import matplotlib.pyplot as plt
import numpy as np
import pandas as pd
import seaborn as sns
import urllib.request

from sklearn.metrics import classification_report
from sklearn.metrics import accuracy_score
from sklearn.model_selection import train_test_split
from sklearn.neighbors import KNeighborsClassifier
from pandas.io.json import json_normalize


### def function read json
def readJsonDecode(urlPath):
  with urllib.request.urlopen(urlPath) as url:
    output = json.loads(url.read().decode())

  return output


### 1) 读入数据, 将json串解析为DataFrame
# pathUrl = 'http://localhost:8888/5wan/web/dashjson/game/dataset?ave_win=2.76&diff_win=0.1&tags=英冠'
pathUrl = 'http://localhost:8888/5wan/web/modules/custom/titanic/src/sklearn_game_train.json'
jsonData = readJsonDecode(pathUrl)
jsonDataDf = json_normalize(jsonData)

gameDF = jsonDataDf[['ave_win', 'ave_draw', 'ave_loss', 'ini_win', 'ini_draw', 'ini_loss', 'diff_win', 'diff_draw', 'diff_loss']]
resultNdArray = jsonDataDf[['Result']]

### 2) split
X_train, X_test, y_train, y_test = train_test_split(gameDF, resultNdArray, test_size = 0.3)

### 2) 数据信息总览：
print("# Game Data Info")
jsonDataDf.info()
print("")


### 3) 分类报告, 按类别输出 准确率，召回率， F1值
def printClassificationReport(model, X_test):
  y_predict = model.predict(X_test)

  print("#  ")
  print(model)
  print(classification_report(y_test, y_predict))

### 1） KNN算法， KNeighborsClassifier()
model = KNeighborsClassifier()
model.fit(X_train, y_train.values.ravel())

printClassificationReport(model, X_test)


### 朴素贝叶斯：
from sklearn.naive_bayes import GaussianNB

model = GaussianNB()
model.fit(X_train, y_train.values.ravel())

printClassificationReport(model, X_test)


### 决策树, 分类和回归树（CART）
from sklearn.tree import DecisionTreeClassifier

model = DecisionTreeClassifier()
model.fit(X_train, y_train.values.ravel())

printClassificationReport(model, X_test)


### 支持向量机 SVM（支持向量机）
from sklearn.svm import SVC

model = SVC()
model.fit(X_train, y_train.values.ravel())

printClassificationReport(model, X_test)

exit()

### 观察前几行的源数据：
# sns.set_style('whitegrid')
# print("# X_train Data Head Teaser")
# print(y_train.head(10))

### print model
# print(y_predict)
# print(y_test.describe())



### new DataFrame to compare y_test with y_predict
compareDF = pd.DataFrame()
compareDF['y_test'] = y_test.values.ravel()
compareDF['y_predict'] = y_predict
## 对比结果
compareDF['Result'] = 0
compareDF.loc[(compareDF['y_test'] == compareDF['y_predict']), "Result"] = 1

# print("# Compare Predict Result")
# print(compareDF['Result'].value_counts())
# print(compareDF['Result'].value_counts(normalize = True))
fig = plt.figure(figsize = (16, 6))
plt.subplot2grid((1, 2), (0, 0))
compareDF['Result'].value_counts(normalize = True).plot(kind = "bar", alpha = 0.5)
plt.title("Percentage")

plt.subplot2grid((1, 2), (0, 1))
compareDF['Result'].value_counts().plot(kind = "bar", alpha = 0.5)
plt.title("Number")
# plt.show()

