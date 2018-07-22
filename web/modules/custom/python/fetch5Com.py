"""
python3 web/modules/custom/python/fetch5Com.py

"""

from FetchPageClass import FetchPageBasic

def generateUrl(id):
  url = 'http://odds.500.com/fenxi/ouzhi-' + str(id) + '.shtml'

  return url

for num in range(520000, 520004):
  print(num)
  url = generateUrl(num)

  gameObj = FetchPageBasic(url)
  cc = gameObj.convertPageResultDict()
  print(cc)

exit()


exit()
# soupPageTitle, soupGameTime, soupGameResult, use this url
url = 'http://odds.500.com/fenxi/ouzhi-520156.shtml'
url = 'http://odds.500.com/fenxi/ouzhi-741189.shtml'

# findGameOddList and findCompanyList use this url
# url = 'http://odds.500.com/fenxi1/ouzhi.php?id=523156&style=1&start=1&last=1'


gameObj = FetchPageBasic(url)

cc = gameObj.convertPageResultDict()

exit()



gameObj.findCompanyList()
gameObj.findGameOddList()

gameObj.getWebSourceText()
