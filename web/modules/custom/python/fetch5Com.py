"""
python3 web/modules/custom/python/fetch5Com.py

"""
import pandas as pd

from FetchPageClass import FetchPageBasic
from BaseSiteClass import Baseinfo
from FlexJsonClass import FlexJsonBasic

#%%

# start from 520000
startNum = 526000
startNum = FlexJsonBasic().getStartNumFromJson()

#
fileName = 'downloadGameInfo.json'
jsonFilePath = FlexJsonBasic().getGenerateJsonFilePath(fileName)

for num in range(startNum, (startNum + 10000)):
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
  FlexJsonBasic().generateJsonForPageId(pageIdJsonContentDataFrame)

exit()
