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
startNum = 522889
endNum   = startNum + 100

fileName = 'downloadGameInfo.json'
jsonFilePath = FlexJsonBasic().getGenerateJsonFilePath(fileName)

for num in range(startNum, endNum):
  jsonContentDict = {}
  url = Baseinfo().generateUrl(num)
  print(url)
  gameObj = FetchPageBasic(url)

  jsonContentFromFile = FlexJsonBasic().readJsonContent(jsonFilePath)
  jsonContentFromFile[num] = gameObj.convertPageResultDict()

  jsonContent = pd.DataFrame.from_dict(jsonContentFromFile)

  FlexJsonBasic().generateJsonFromData(jsonFilePath, jsonContent)

exit()
