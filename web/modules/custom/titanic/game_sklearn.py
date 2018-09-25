"""
python3 web/modules/custom/titanic/sklearn_game.py
因为读入数据有中文，在sublime text内运行有问题，需要到命令行运行
"""

# -*- coding: utf-8 -*-
import matplotlib.pyplot as plt
import numpy as np
import pandas as pd
import seaborn as sns

from sklearn import cross_validation
from sklearn import preprocessing


### 1) 读入数据, 将json串解析为DataFrame
from game_json import GameJsonClass
jsonDataDf = GameJsonClass().getJsonContent()

jsonDataDf['ave_win'] = jsonDataDf['ave_win'].astype(float)
jsonDataDf['ave_draw'] = jsonDataDf['ave_draw'].astype(float)
jsonDataDf['ave_loss'] = jsonDataDf['ave_loss'].astype(float)
jsonDataDf['Result'] = jsonDataDf['Result'].astype(int)

jsonDataDf = jsonDataDf[(jsonDataDf['tags'] == "法甲") | (jsonDataDf['tags'] == "法乙")]
jsonDataDf = jsonDataDf[jsonDataDf['ave_loss'] < 2.6]


### ) 数据信息总览：
print("# Game Data Info")
jsonDataDf.info()
print("")


### ) 生产 X y
X = jsonDataDf[['ave_win', 'ave_draw', 'ave_loss', 'ini_win', 'ini_draw', 'ini_loss', 'diff_win', 'diff_draw', 'diff_loss']]
X = jsonDataDf[['ini_win', 'ini_draw', 'ini_loss', 'diff_win', 'diff_draw', 'diff_loss']]
y = jsonDataDf[['Result']].values.ravel()

### 2) Standardization of datasets, normalization
X_scaled = preprocessing.scale(X)

### 3) split
from sklearn.model_selection import train_test_split
X_train, X_test, y_train, y_test = train_test_split(X_scaled, y, test_size = 0.3)


from game_sklearn_fn import GameSklearnFnClass


### 5. 构建模型和评估模型,
### 1）朴素贝叶斯：
from sklearn.naive_bayes import GaussianNB

model = GaussianNB()
model.fit(X_train, y_train)

GameSklearnFnClass().printClassificationReport(model, X_test, y_test)


exit()
## 交叉验证 sklearn.model_selection.cross_val_score
# cross_score = cross_validation.cross_val_score(model, X_scaled, y, scoring = 'accuracy', cv = 5)
# print(cross_score)



### 2） KNN算法， KNeighborsClassifier()
from sklearn.neighbors import KNeighborsClassifier
model = KNeighborsClassifier()
model.fit(X_train, y_train)

printClassificationReport(model, X_test, y_test)


### 决策树, 分类和回归树（CART）
from sklearn.tree import DecisionTreeClassifier

model = DecisionTreeClassifier()
model.fit(X_train, y_train)

printClassificationReport(model, X_test, y_test)

exit()

### 支持向量机 SVM（支持向量机）
from sklearn.svm import SVC

model = SVC()
model.fit(X_train, y_train)

printClassificationReport(model, X_test, y_test)

exit()


### new DataFrame to compare y_test with y_predict
y_predict = model.predict(X_test)

compareDF = pd.DataFrame()
compareDF['y_test'] = y_test
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
plt.show()

exit()


