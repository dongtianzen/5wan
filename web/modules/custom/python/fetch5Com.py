"""
python3 web/modules/custom/python/fetch5Com.py

"""
import pandas as pd

from FetchPageClass import FetchPageBasic
from BaseSiteClass import Baseinfo
from FlexJsonClass import FlexJsonBasic

#%%

# start from 520000
# http://odds.500.com/fenxi/ouzhi-521930.shtml
startNum = 522000
endNum   = startNum + 300

jsonContentDict = {}
for num in range(startNum, endNum):
  url = Baseinfo().generateUrl(num)
  print(url)
  gameObj = FetchPageBasic(url)
  jsonContentDict[num] = gameObj.convertPageResultDict()

# jsonContentDict[666] =  {'ini_win': '2.74', 'ini_draw': '3.20', 'ini_loss': '2.47'}

jsonContent = pd.DataFrame.from_dict(jsonContentDict)

fileName = 'downloadGameInfo.json'
jsonFilePath = FlexJsonBasic().getGenerateJsonFilePath(fileName)
FlexJsonBasic().generateJsonFromData(jsonFilePath, jsonContent)

exit()

gameObj = FetchPageBasic(url)
cc = gameObj.convertPageResultDict()
print(cc)
