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

# 花有三个类别，分别用0，1，2来代表
iris_target = iris.target

# data
iris_ndArray = iris.data

# @param test_size 占 30%
irisTrain, irisTest, targetTrain, targetTest = train_test_split(iris.data, iris.target, test_size = 0.3)

# ndarray.shape：数组每一维的大小
print(irisTrain.shape)
print(irisTest.shape)

# ndarray.size：数组中全部元素的数量
print(targetTrain.size)
print(targetTest.size)

## KNN算法， KNeighborsClassifier()
knn = KNeighborsClassifier()
knn.fit(irisTrain, targetTrain)

testPredict = knn.predict(irisTest)
print(testPredict)
print(targetTest)

## 分类报告
# classification_report函数构建了一个文本报告，用于展示主要的分类
# 按类别输出 准确率，召回率， F1值--平衡F-score

print(classification_report(targetTest, testPredict))

resultDF = pd.DataFrame()

resultDF['Target'] = targetTest
resultDF['Predict'] = testPredict
resultDF['Result'] = 0

resultDF.loc[resultDF['Target'] == resultDF['Predict'], "Result"] = 1
print(resultDF)

print(resultDF['Result'].value_counts(normalize = True))
print(resultDF['Result'].value_counts())


exit()

### SVM分类器
clf = svm.SVC(C=0.1, kernel='linear', decision_function_shape='ovr')

# 不同的参数调试
# clf = svm.SVC(C=0.8, kernel='rbf', gamma=20, decision_function_shape='ovr')
clf.fit(irisTrain, targetTrain)

# 准确率
# 精度
print (clf.score(irisTrain, targetTrain))
print ('Train set accuracy_score is:', accuracy_score(targetTrain, clf.predict(irisTrain)))
print (clf.score(irisTest, targetTest))
print ('Test set accuracy_score is', accuracy_score(targetTest, clf.predict(irisTest)))

# decision_function
# 计算样本点到分割超平面的函数距离
# print ('decision_function:\n', clf.decision_function(irisTrain))
# print ('\npredict:\n', clf.predict(irisTrain))





