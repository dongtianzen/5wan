"""
python3 web/modules/custom/titanic/5wan_bonus.py

"""

from pandas.io.json import json_normalize
import pandas as pd
import html5lib
import json
import time

# 读入数据
data_str = pd.read_html('http://localhost:8888/5wan/web/dashpage/game/list/json?ave_win=2.76&ave_draw=2.50&ave_loss=2.80').read()
print(data_str)
