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

import numpy as np
from sklearn import datasets
from sklearn.model_selection import train_test_split
from sklearn.neighbors import KNeighborsClassifier

iris = datasets.load_iris()
print(type(iris))
print((iris))
