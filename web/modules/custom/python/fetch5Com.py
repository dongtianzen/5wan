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
startNum = 526000

pageIdFileName = 'startPageId.json'
pageIdJsonFilePath = FlexJsonBasic().getGenerateJsonFilePath(pageIdFileName)
pageIdJsonContent = FlexJsonBasic().readJsonContent(pageIdJsonFilePath)

startNum = pageIdJsonContent["0"]["id"]
endNum   = startNum + 10000

#
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

  #
  pageIdJsonContent = { "id" : num}

  pageIdJsonContentDataFrame = pd.DataFrame.from_dict(pageIdJsonContent, orient = 'index')
  FlexJsonBasic().generateJsonFromData(pageIdJsonFilePath, pageIdJsonContentDataFrame)

exit()
