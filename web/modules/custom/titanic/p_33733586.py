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

train = pd.read_csv('web/modules/custom/titanic/src/train.csv', dtype={"Age": np.float64})
test  = pd.read_csv('web/modules/custom/titanic/src/test.csv', dtype={"Age": np.float64})

PassengerId = test['PassengerId']
all_data = pd.concat([train, test], ignore_index = True)


### 数据可视化
# 1) Sex Feature：女性幸存率远高于男性
sns.barplot(x="Sex", y="Survived", data=train, palette='Set3')

# 2) Pclass Feature：乘客社会等级越高，幸存率越高
sns.barplot(x="Pclass", y="Survived", data=train, palette='Set3')

# 5) Age Feature：未成年人幸存率高于成年人
# 面积图，折线图
facet = sns.FacetGrid(train, hue="Survived", aspect=2)
facet.map(sns.kdeplot, 'Age', shade= True)
facet.set(xlim=(0, train['Age'].max()))
facet.add_legend()

# 6) Fare Feature：支出船票费越高幸存率越高

facet = sns.FacetGrid(train, hue="Survived",aspect=2)
facet.map(sns.kdeplot,'Fare',shade= True)
facet.set(xlim=(0, 300))
facet.add_legend()


# 8) FamilyLabel Feature(New)：家庭人数为2到4的乘客幸存率较高
# 新创建一个变量
all_data['FamilySize'] = all_data['SibSp'] + all_data['Parch'] + 1

sns.barplot(x = "FamilySize", y = "Survived", data = all_data, palette = 'Set3')

# 再按生存率把FamilySize分为三类，构成FamilyLabel特征
def Fam_label(s):
    if (s >= 2) & (s <= 4):
        return 2
    elif ((s > 4) & (s <= 7)) | (s == 1):
        return 1
    elif (s > 7):
        return 0
all_data['FamilyLabel']=all_data['FamilySize'].apply(Fam_label)

sns.barplot(x="FamilyLabel", y="Survived", data=all_data, palette='Set3')


plt.show()

