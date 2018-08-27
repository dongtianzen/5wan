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
from sklearn.pipeline import Pipeline, make_pipeline
from sklearn.ensemble import GradientBoostingClassifier, RandomForestClassifier
from sklearn.feature_selection import SelectKBest
# from sklearn import cross_validation, metrics
from sklearn.grid_search import GridSearchCV, RandomizedSearchCV

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

# plt.show()

# 因为普遍规律是女性和儿童幸存率高，成年男性幸存较低，所以我们把不符合普遍规律的反常组选出来单独处理。
# 把女性和儿童组中幸存率为0的组设置为遇难组，把成年男性组中存活率为1的设置为幸存组，
# 推测处于遇难组的女性和儿童幸存的可能性较低，处于幸存组的成年男性幸存的可能性较高。

Female_Child_Group = Female_Child_Group.groupby('Surname')['Survived'].mean()
Dead_List = set(Female_Child_Group[Female_Child_Group.apply(lambda x:x == 0)].index)
print(Dead_List)

Male_Adult_List = Male_Adult_Group.groupby('Surname')['Survived'].mean()
Survived_List = set(Male_Adult_List[Male_Adult_List.apply(lambda x:x == 1)].index)
print(Survived_List)

# 为了使处于这两种反常组中的样本能够被正确分类，对测试集中处于反常组中的样本的Age，Title，Sex进行惩罚修改。

train=all_data.loc[all_data['Survived'].notnull()]
test=all_data.loc[all_data['Survived'].isnull()]
test.loc[(test['Surname'].apply(lambda x:x in Dead_List)),'Sex'] = 'male'
test.loc[(test['Surname'].apply(lambda x:x in Dead_List)),'Age'] = 60
test.loc[(test['Surname'].apply(lambda x:x in Dead_List)),'Title'] = 'Mr'
test.loc[(test['Surname'].apply(lambda x:x in Survived_List)),'Sex'] = 'female'
test.loc[(test['Surname'].apply(lambda x:x in Survived_List)),'Age'] = 5
test.loc[(test['Surname'].apply(lambda x:x in Survived_List)),'Title'] = 'Miss'

# 3) 特征转换
# 选取特征，转换为数值变量，划分训练集和测试集。

all_data = pd.concat([train, test])
all_data = all_data[['Survived','Pclass','Sex','Age','Fare','Embarked','Title','FamilyLabel','Deck','TicketGroup']]
all_data = pd.get_dummies(all_data)
train = all_data[all_data['Survived'].notnull()]
test = all_data[all_data['Survived'].isnull()].drop('Survived',axis=1)
X = train.as_matrix()[:,1:]
y = train.as_matrix()[:,0]

# 5. 建模和优化
# 1) 参数优化
#
# 用网格搜索自动化选取最优参数，事实上我用网格搜索得到的最优参数是n_estimators = 28，max_depth = 6。
# 但是参考另一篇Kernel把参数改为n_estimators = 26，max_depth = 6之后交叉验证分数和kaggle评分都有略微提升。
pipe = Pipeline([('select',SelectKBest(k=20)),
               ('classify', RandomForestClassifier(random_state = 10, max_features = 'sqrt'))])

param_test = {'classify__n_estimators':list(range(20,50,2)),
              'classify__max_depth':list(range(3,60,3))}
gsearch = GridSearchCV(estimator = pipe, param_grid = param_test, scoring='roc_auc', cv=10)
gsearch.fit(X, y)
print(gsearch.best_params_, gsearch.best_score_)

