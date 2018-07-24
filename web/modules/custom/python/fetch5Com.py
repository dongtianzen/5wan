"""
python3 web/modules/custom/python/fetch5Com.py

"""
import pandas as pd

from FetchPageClass import FetchPageBasic
from BaseSiteClass import Baseinfo
from FlexJsonClass import FlexJsonBasic

#%%
jsonContentDict = {}
for num in range(520300, 520500):
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
