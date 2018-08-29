"""
python3 web/modules/custom/titanic/youtube_B3cI_Ls_3Gk.py

"""

"""
Solving Kaggle's Titanic: Machine Learning from Disaster with Python
https://www.youtube.com/watch?v=B3cI_Ls_3Gk
"""

import pandas as pd
import matplotlib.pyplot as plt


# 观察前几行的源数据：
trainData = pd.read_csv('/Applications/MAMP/htdocs/5wan/web/modules/custom/titanic/src/train.csv')

print(trainData.shape)
print(trainData.count())

trainSurvivedCount = trainData.Survived.value_counts()
print(trainSurvivedCount)

fig = plt.figure(figsize = (18, 6))
trainSurvivedCount.plot(kind = "bar", alpha = 0.5)
plt.title("Survived Number")
plt.show()

plt.scatter(trainData.Survived, trainData.Age, alpha = 0.1)
plt.title("Age vs Survived")

plt.show()



