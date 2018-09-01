"""
python3 web/modules/custom/titanic/youtube_B3cI_Ls_3Gk.py

"""

"""
Solving Kaggle's Titanic: Machine Learning from Disaster with Python
https://www.youtube.com/watch?v=B3cI_Ls_3Gk
"""

import matplotlib.pyplot as plt
import pandas as pd
# import utils
from sklearn import linear_model




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
features = trainData[['Pclass', 'Age', 'Sex', 'SibSp', 'Parch']].values

classifier = linear_model.LogisticRegression()
classifier_fit = classifier.fit(features, target)

# 逻辑回归, 分数0.7934904601571269
classifier_score = classifier_fit.score(features, target)

print("")
print(classifier_score)

# sampleDataDF = trainData[['Sex', 'Hyp']]
# pd.set_option('display.max_columns', None)
# print(sampleDataDF)
# print(trainData[['Sex', 'Hyp', 'Survived', 'Result']])



