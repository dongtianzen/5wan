"""
python3 web/modules/custom/titanic/zucai.py

"""

import matplotlib.pyplot as plt
import pandas as pd


# 0） 导入
trainDF = pd.read_csv('/Applications/MAMP/htdocs/5wan/web/modules/custom/titanic/src/zucai_bonus.csv')

## 观察源数据：
print("# Data Shape ")
print(trainDF.shape)
print("# Data Count ")
print(trainDF.count())

# 1） 新建比较数据

trainDF['CompareNum'] = 0
trainDF['CompareBonus'] = 0

trainDF.loc[trainDF.Num9 > trainDF.NumSilver, "CompareNum"] = 1
trainDF.loc[trainDF.Bonus9 > trainDF.BonusSilver, "CompareBonus"] = 1

print(trainDF['CompareNum'].value_counts())
print(trainDF['CompareBonus'].value_counts())

## 绘图
fig = plt.figure(figsize = (18, 6))

plt.subplot2grid((2, 3), (0, 0))
trainDF['CompareNum'].value_counts().plot(kind = "bar", alpha = 0.5)
plt.title("Compare Num")

plt.subplot2grid((2, 3), (0, 1))
trainDF['CompareBonus'].value_counts().plot(kind = "bar", alpha = 0.5)
plt.title("Compare Bonus")

print(trainDF[['Num9', 'NumSilver', 'CompareNum']])
print(trainDF[['Bonus9', 'BonusSilver', 'CompareBonus']])


# df.plot(x="X", y=["A", "B", "C"], kind="bar")

plt.show()
