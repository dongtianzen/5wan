"""
python3 web/modules/custom/titanic/game_json.py
因为读入数据有中文，在sublime text内运行有问题，需要到命令行运行
"""
# -*- coding: utf-8 -*-

import json
import urllib.request

import pandas as pd

from pandas.io.json import json_normalize



# define a class
class GameJsonClass:

  # def function read json
  def readJsonDecode(self, urlPath):
    with urllib.request.urlopen(urlPath) as url:
      output = json.loads(url.read().decode('utf-8'))

    return output

  # 读入数据, 将json串解析为DataFrame
  def getJsonContent(self):
    # pathUrl = 'http://localhost:8888/5wan/web/dashjson/game/dataset?ave_win=2.76&diff_win=0.001'
    pathUrl = 'http://localhost:8888/5wan/web/sites/default/files/titanic/src/sklearn_game_train.json'

    jsonData = self.readJsonDecode(pathUrl)
    jsonDataDf = json_normalize(jsonData)

    return jsonDataDf

  # 读入数据, 将json Dict 解析为DataFrame
  def getJsonFromDictContent(self):
    pathUrl = 'http://localhost:8888/5wan/web/dashjson/game/fields/value?ave_win=2.86&diff_win=0.03&ave_draw=2.76'

    jsonData = self.readJsonDecode(pathUrl)
    jsonDataDf = pd.DataFrame.from_dict(jsonData)

    return jsonDataDf

##

### ) 数据信息总览：
# jsonDataDf = GameJsonClass().getJsonContent()
# print("# Game Data Info")
# jsonDataDf.info()
# print("")
