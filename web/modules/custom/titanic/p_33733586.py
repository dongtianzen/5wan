"""
python3 web/modules/custom/titanic/p_33733586.py

"""

"""
Kaggle Titanic 生存预测(Top1.4%)完整代码分享
https://zhuanlan.zhihu.com/p/33733586

"""

# 导入包与加载数据

# %matplotlib inline
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns

from sklearn.ensemble import RandomForestRegressor
from sklearn.pipeline import Pipeline,make_pipeline
from sklearn.ensemble import GradientBoostingClassifier, RandomForestClassifier
from sklearn.feature_selection import SelectKBest
# from sklearn import cross_validation, metrics
# from sklearn.grid_search import GridSearchCV, RandomizedSearchCV

import warnings
warnings.filterwarnings('ignore')

train = pd.read_csv('web/modules/custom/titanic/src/train.csv',dtype={"Age": np.float64})
test = pd.read_csv('web/modules/custom/titanic/src/test.csv',dtype={"Age": np.float64})

PassengerId = test['PassengerId']
all_data = pd.concat([train, test], ignore_index = True)



### 数据可视化
# 1) Sex Feature：女性幸存率远高于男性
sns.barplot(x="Sex", y="Survived", data=train, palette='Set3')
print("Percentage of females who survived:%.2f" % (train["Survived"][train["Sex"] == 'female'].value_counts(normalize = True)[1]*100))
print("Percentage of males who survived:%.2f" % (train["Survived"][train["Sex"] == 'male'].value_counts(normalize = True)[1]*100))

plt.show()

ax = sns.barplot(x="Pclass", y="Survived", data=train, palette='Set3')

plt.show()
