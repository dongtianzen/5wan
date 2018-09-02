"""
python3 web/modules/custom/titanic/youtube_B3cI_Ls_3Gk.py

"""

"""
Solving Kaggle's Titanic: Machine Learning from Disaster with Python
https://www.youtube.com/watch?v=B3cI_Ls_3Gk

https://github.com/Arkham/jack-dies
"""

import matplotlib.pyplot as plt
import pandas as pd
# import utils
from sklearn import linear_model, preprocessing, tree, model_selection


# 0） 导入
trainData = pd.read_csv('/Applications/MAMP/htdocs/5wan/web/modules/custom/titanic/src/train.csv')

## 观察源数据：
print("# Data Shape ")
print(trainData.shape)
print("")
print("# Data Count ")
print(trainData.count())

# 1）观察Survived
trainSurvivedCount = trainData.Survived.value_counts()
print("# Survived Count ")
print(trainSurvivedCount)

## 绘图
fig = plt.figure(figsize = (18, 6))

plt.subplot2grid((2, 3), (0, 0))
trainSurvivedCount.plot(kind = "bar", alpha = 0.5)
plt.title("Survived Number")

plt.subplot2grid((2, 3), (0, 1))
plt.scatter(trainData.Survived, trainData.Age, alpha = 0.1)
plt.title("Age vs Survived")

plt.subplot2grid((2, 3), (0, 2))
trainData.Pclass.value_counts().plot(kind = "bar", alpha = 0.5)
plt.title("Pclass Number")

## 画核密度估计Kernel Density Estimation
plt.subplot2grid((2, 3), (1, 0), colspan = 2)
for x in [1, 2, 3]:
  trainData.Age[trainData.Pclass == x].plot(kind = "kde")
plt.title("Class vs Age")
plt.legend(("1st", "2nd", "3rd"))

plt.subplot2grid((2, 3), (1, 2))
trainData.Embarked.value_counts().plot(kind = "bar", alpha = 0.5)
plt.title("Embarked Number")

# plt.show()

## 绘图 for Gender
## normalize = True, 显示百分比
fig = plt.figure(figsize = (18, 6))

plt.subplot2grid((3, 4), (0, 0))
trainData.Survived.value_counts(normalize = True).plot(kind = "bar", alpha = 0.5)
plt.title("Survived Percentage")

plt.subplot2grid((3, 4), (0, 1))
trainData.Survived[trainData.Sex == 'male'].value_counts(normalize = True).plot(kind = "bar", alpha = 0.5)
plt.title("Survived Men")

plt.subplot2grid((3, 4), (0, 2))
trainData.Survived[trainData.Sex == 'female'].value_counts(normalize = True).plot(kind = "bar", alpha = 0.5)
plt.title("Survived Woemn")

plt.subplot2grid((3, 4), (0, 3))
trainData.Sex[trainData.Survived == 1].value_counts(normalize = True).plot(kind = "bar", alpha = 0.5)
plt.title("Gender of Survived")

## 画核密度估计Kernel Density Estimation
plt.subplot2grid((3, 4), (1, 0), colspan = 4)
for x in [1, 2, 3]:
  trainData.Survived[trainData.Pclass == x].plot(kind = "kde")
plt.title("Class vs Survived")
plt.legend(("1st", "2nd", "3rd"))

plt.subplot2grid((3, 4), (2, 0))
trainData.Survived[(trainData.Sex == 'male') & (trainData.Pclass == 1)].value_counts(normalize = True).plot(kind = "bar", alpha = 0.5)
plt.title("Rich Men Survived")

plt.subplot2grid((3, 4), (2, 1))
trainData.Survived[(trainData.Sex == 'male') & (trainData.Pclass == 3)].value_counts(normalize = True).plot(kind = "bar", alpha = 0.5)
plt.title("Poor Men Survived")

plt.subplot2grid((3, 4), (2, 2))
trainData.Survived[(trainData.Sex == 'female') & (trainData.Pclass == 1)].value_counts(normalize = True).plot(kind = "bar", alpha = 0.5)
plt.title("Rich Women Survived")

plt.subplot2grid((3, 4), (2, 3))
trainData.Survived[(trainData.Sex == 'female') & (trainData.Pclass == 3)].value_counts(normalize = True).plot(kind = "bar", alpha = 0.5)
plt.title("Poor Women Survived")

# plt.show()

# 2）predict

## add new column - Hypothesis
trainData['Hyp'] = 0
trainData['Result'] = 0

trainData.loc[trainData.Sex == "female", "Hyp"] = 1

## 假设 如果Survived等于Hypothesis，预测结果为1，即假设female是Survived， 或mail没有Survived
## 两种写法都可以
# trainData.loc[trainData['Survived'] == trainData["Hyp"], "Result"] = 1
trainData.loc[trainData.Survived == trainData.Hyp, "Result"] = 1

# print(trainData['Result'].value_counts())
print("")
print("# Survived Hypothesis Percentage:")
print(trainData['Result'].value_counts(normalize = True))
## 第一步假设 准确率78.67%

# 3）def function to 填充NA / NaN值, 和转换数据
def clean_data(data):
  data['Fare'] = data['Fare'].fillna(data['Fare'].dropna().median())
  data['Age'] = data['Age'].fillna(data['Age'].dropna().median())

  data.loc[data['Sex'] == "male", "Sex"] = 0
  data.loc[data['Sex'] == "female", "Sex"] = 1

  data['Embarked'] = data['Embarked'].fillna("S")
  data.loc[data['Embarked'] == "S", "Embarked"] = 0
  data.loc[data['Embarked'] == "C", "Embarked"] = 1
  data.loc[data['Embarked'] == "Q", "Embarked"] = 2

  ###

# 4）Predict Logistic Regression

clean_data(trainData)

target = trainData['Survived'].values
classifier = linear_model.LogisticRegression()

## 5 dimensions
features = trainData[['Pclass', 'Age', 'Sex', 'SibSp', 'Parch']].values

# 逻辑回归, 分数0.7934904601571269
classifier_fit = classifier.fit(features, target)
classifier_score = classifier_fit.score(features, target)

## add two dimensions
features = trainData[['Pclass', 'Age', 'Fare', 'Embarked', 'Sex', 'SibSp', 'Parch']].values

# 逻辑回归, 分数0.7991021324354658, 比上一个高了一点点
classifier_fit = classifier.fit(features, target)
classifier_score = classifier_fit.score(features, target)


# 5）sklearn.preprocessing.PolynomialFeatures，可以理解为专门生成多项式特征
## 多项式阶数，设为2
poly = preprocessing.PolynomialFeatures(degree = 2)
poly_features = poly.fit_transform(features)

# PolynomialFeatures分数 0.8316498316498316
classifier_fit = classifier.fit(poly_features, target)
classifier_score = classifier_fit.score(poly_features, target)

print("")
print("# PolynomialFeatures Score:")
print(classifier_score)

# 6）Decision Tree, sklearn.tree.DecisionTreeClassifier
feature_dimensions = ['Pclass', 'Age', 'Fare', 'Embarked', 'Sex', 'SibSp', 'Parch']

dimension_tree = tree.DecisionTreeClassifier(
  random_state = 1
)

# DecisionTreeClassifier 分数 0.9797979797979798
dimension_tree_fit = dimension_tree.fit(features, target)
dimension_tree_score = dimension_tree_fit.score(features, target)

print("")
print("# DecisionTreeClassifier Score:")
print(dimension_tree_score)

# 7) 交叉验证 sklearn.model_selection.cross_val_score
## add 参数
## max_depth 应该和feature_dimensions数组长度一样，或不小于长度
dimension_tree = tree.DecisionTreeClassifier(
  max_depth = 7,
  min_samples_split = 2,
  random_state = 1
)

cross_score = model_selection.cross_val_score(dimension_tree, features, target, scoring = 'accuracy', cv = 50)
print("")
print("# cross_val_score Score and means:")
print(cross_score)
print(cross_score.mean())

## export tree graph
dimension_tree_fit = dimension_tree.fit(features, target)
tree.export_graphviz(dimension_tree_fit, feature_names = feature_dimensions, out_file = "./graphs/decision_tree.dot")

## convert Png file
# dot -Tpng ./graphs/decision_tree.dot -o ./graphs/decision_tree.png


# sampleDataDF = trainData[['Sex', 'Hyp']]
# pd.set_option('display.max_columns', None)
# print(sampleDataDF)
# print(trainData[['Sex', 'Hyp', 'Survived', 'Result']])



