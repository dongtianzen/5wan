"""
python3 web/modules/custom/python/fetch5Com.py

"""

from FetchPageClass import FetchPageBasic
from BaseSiteClass import Baseinfo
from FlexJsonClass import FlexJsonBasic

for num in range(520000, 520002):
  url = Baseinfo().generateUrl(num)
  print(url)
  gameObj = FetchPageBasic(url)
  jsonContent = gameObj.convertPageResultDict()
  print(jsonContent)


fileName = 'downloadGameInfo.json'
jsonFilePath = FlexJsonBasic().getGenerateJsonFilePath(fileName)
FlexJsonBasic().generateJsonFromData(jsonFilePath, jsonContent)

exit()


exit()

gameObj = FetchPageBasic(url)

cc = gameObj.convertPageResultDict()

exit()


gameObj.findCompanyList()
gameObj.findGameOddList()

gameObj.getWebSourceText()
