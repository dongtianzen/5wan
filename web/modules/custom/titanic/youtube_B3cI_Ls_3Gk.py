"""
python3 web/modules/custom/titanic/youtube_B3cI_Ls_3Gk.py

"""

"""
Solving Kaggle's Titanic: Machine Learning from Disaster with Python
https://www.youtube.com/watch?v=B3cI_Ls_3Gk
"""

import pandas as pd
import matplotlib.pyplot as plt

# 0） 导入
trainData = pd.read_csv('/Applications/MAMP/htdocs/5wan/web/modules/custom/titanic/src/train.csv')

## 观察源数据：
print("# Data Shape ")
print(trainData.shape)
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
pd.set_option('display.max_columns', None)
# 2）predict
trainData['Hyp'] = 0
trainData.loc[trainData.Sex == "female", "Hyp"] = 1

print(trainData)
