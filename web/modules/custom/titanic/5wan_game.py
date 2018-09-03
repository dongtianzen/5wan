"""
python3 web/modules/custom/titanic/5wan_game.py
因为读入数据有中文，在sublime text内运行有问题，需要到命令行运行
"""

# -*- coding: utf-8 -*-
import pandas as pd
import json
import urllib.request


def readJsonDecode(urlPath):
  with urllib.request.urlopen(urlPath) as url:
    output = json.loads(url.read().decode())

  return output


# 读入数据
pathUrl = 'http://localhost:8888/5wan/web/dashpage/game/list/json?ave_win=7.76'
# data_str = pd.read_json(pathUrl, orient='columns')

data = readJsonDecode(pathUrl)

print(data)
