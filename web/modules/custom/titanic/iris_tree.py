"""
python3 web/modules/custom/titanic/iris_tree.py
"""

from sklearn import datasets
from sklearn import metrics
from sklearn.tree import DecisionTreeClassifier

# 读取 iris 数据集
dataset = datasets.load_iris()
print(dataset)
print("")

# 采用CART模型
model = DecisionTreeClassifier()
model.fit(dataset.data, dataset.target)
print(model)
print("")

# 预测
expected = dataset.target
predicted = model.predict(dataset.data)

# 统计
print(metrics.classification_report(expected, predicted))
print(metrics.confusion_matrix(expected, predicted))

exit()
