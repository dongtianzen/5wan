"""
python3 web/modules/custom/python/fetch5Com.py

"""

from FetchPageClass import FetchPageBasic
from BaseSiteClass import Baseinfo

for num in range(520000, 520004):
  url = Baseinfo().generateUrl(num)
  print(url)
  gameObj = FetchPageBasic(url)
  cc = gameObj.convertPageResultDict()
  print(cc)

exit()


exit()

gameObj = FetchPageBasic(url)

cc = gameObj.convertPageResultDict()

exit()


gameObj.findCompanyList()
gameObj.findGameOddList()

gameObj.getWebSourceText()
