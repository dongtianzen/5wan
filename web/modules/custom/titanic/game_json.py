"""
python3 web/modules/custom/titanic/game_json.py
因为读入数据有中文，在sublime text内运行有问题，需要到命令行运行
"""

import json
import urllib.request

from pandas.io.json import json_normalize


# def function read json
def readJsonDecode(urlPath):
  with urllib.request.urlopen(urlPath) as url:
    output = json.loads(url.read().decode('utf-8'))

  return output


### 1) 读入数据, 将json串解析为DataFrame
# pathUrl = 'http://localhost:8888/5wan/web/dashjson/game/dataset?ave_win=2.76&diff_win=0.1&tags=英冠,英乙,英甲'
pathUrl = 'http://localhost:8888/5wan/web/modules/custom/titanic/src/sklearn_game_train.json'
jsonData = readJsonDecode(pathUrl)

##
jsonDataDf = json_normalize(jsonData)

### ) 数据信息总览：
print("# Game Data Info")
jsonDataDf.info()
print("")
