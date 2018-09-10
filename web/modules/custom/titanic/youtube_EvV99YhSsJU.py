"""
python3 web/modules/custom/titanic/youtube_EvV99YhSsJU.py

"""

"""
Scikit-Learn 4 通用学习模式 (机器学习 sklearn 教学教程tutorial)
https://www.youtube.com/watch?v=EvV99YhSsJU

用 sklearn 自己的 iris 的例子实现了一次 KNeighborsClassifier 学习.
说明了所有 sklearn的编程结构和过程都是极度类似的.所以只需要先定义 用什么model学习,然后再 model.fit(数据),
这样 model 就能从数据中学到东西. 最后还可以用 model.predict() 来预测值

"""

import matplotlib.pyplot as plt
import numpy as np
import pandas as pd

from sklearn import datasets
from sklearn import svm
from sklearn.metrics import classification_report
from sklearn.metrics import accuracy_score
from sklearn.model_selection import train_test_split
from sklearn.neighbors import KNeighborsClassifier

iris = datasets.load_iris()

# iris.target 花有三个类别，分别用0，1，2来代表
# iris.data 存放数据

# @param test_size 占 30%
X_train, X_test, y_train, y_test = train_test_split(iris.data, iris.target, test_size = 0.3)

# ndarray.shape：数组每一维的大小
print(X_train.shape)
print(X_test.shape)

# ndarray.size：数组中全部元素的数量
print(y_train.size)
print(y_test.size)

### 1） KNN算法， KNeighborsClassifier()
knnModal = KNeighborsClassifier()
knnModal.fit(X_train, y_train)

testPredict = knnModal.predict(X_test)

# print model
print(knnModal)
print(testPredict)
print(y_test)

## 分类报告
## classification_report函数构建了一个文本报告，用于展示主要的分类
## 按类别输出 准确率，召回率， F1值--平衡F-score

print(classification_report(y_test, testPredict))

## new DataFrame
resultDF = pd.DataFrame()
resultDF['y_test'] = y_test
resultDF['Predict'] = testPredict
## 对比结果
resultDF['Result'] = 0
resultDF.loc[resultDF['y_test'] == resultDF['Predict'], "Result"] = 1

print("# Compare Predict Result")
print(resultDF['Result'].value_counts())
print(resultDF['Result'].value_counts(normalize = True))
# resultDF['Result'].value_counts().plot(kind = "bar", alpha = 0.5)
# plt.show()


### 2） 朴素贝叶斯
from sklearn import metrics
from sklearn.naive_bayes import GaussianNB

model = GaussianNB()
# model.fit(X, y)
model.fit(X_train, y_train)

print("#")
print(model)

# make predictions
expected = y_train

predicted = model.predict(X_train)
# summarize the fit of the model
print(metrics.classification_report(expected, predicted))
print(metrics.confusion_matrix(expected, predicted))

print(classification_report(y_test, testPredict))

## new DataFrame
resultDF = pd.DataFrame()
resultDF['y_test'] = y_test
resultDF['Predict'] = testPredict
## 对比结果
resultDF['Result'] = 0
resultDF.loc[resultDF['y_test'] == resultDF['Predict'], "Result"] = 1
print(resultDF)

exit()

### 3） SVM分类器
clf = svm.SVC(C = 0.1, kernel = 'linear', decision_function_shape = 'ovr')

# 不同的参数调试
# clf = svm.SVC(C=0.8, kernel='rbf', gamma=20, decision_function_shape='ovr')
clf.fit(X_train, y_train)

# 准确率
# 精度
print (clf.score(X_train, y_train))
print ('Train set accuracy_score is:', accuracy_score(y_train, clf.predict(X_train)))
print (clf.score(X_test, y_test))
print ('Test set accuracy_score is', accuracy_score(y_test, clf.predict(X_test)))

# decision_function
# 计算样本点到分割超平面的函数距离
# print ('decision_function:\n', clf.decision_function(X_train))
# print ('\npredict:\n', clf.predict(X_train))





