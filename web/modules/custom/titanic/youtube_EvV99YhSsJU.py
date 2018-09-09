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

from sklearn import datasets
from sklearn.model_selection import train_test_split
from sklearn.neighbors import KNeighborsClassifier

iris = datasets.load_iris()

# 花有三个类别，分别用0，1，2来代表
iris_target = iris.target

# data
iris_ndArray = iris.data

# @param test_size 占 30%
irisTrain, irisTest, targetTrain, targetTest = train_test_split(iris.data, iris.target, test_size = 0.3)
print(irisTrain.shape)
print(irisTest.shape)
print(targetTrain.size)
print(targetTest.size)

knn = KNeighborsClassifier()
knn.fit(irisTrain, targetTrain)

testPredict = knn.predict(irisTest)
print(testPredict)
print(targetTest)

# width = 0.35
# fig, ax = plt.subplots()
# ax.bar(testPredict, targetTest, width, color='r')
# plt.show()





