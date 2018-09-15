#

from sklearn.metrics import classification_report

# define a class
class GameSklearnFnClass:

  ### 5) 分类报告, 按类别输出 准确率，召回率， F1值
  def printClassificationReport(self, model, X_test, y_test):
    y_predict = model.predict(X_test)

    print("#  ")
    print(model)
    print(classification_report(y_test, y_predict))

    # print(model.score(X_test, y_test))


    #-->

  ### 6) joblib 存取model, 导出训练好的参数, 重新创建一个相同结构, 再把参数放进去比较好﻿
  def saveModel(self, model):
    from sklearn.externals import joblib

    # save
    joblib.dump(model, 'save/model.pkl')

    # restore
    restoreModel = joblib.load(model, 'save/model.pkl')

    # print(model.score(X_test, y_test))

    #-->
