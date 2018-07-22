"""
python3 web/modules/custom/python/fetch5Com.py

"""

# from FetchPageClass import FetchPageBasic

def generateUrl(id):
  url = 'http://odds.500.com/fenxi/ouzhi-' + str(id) + '.shtml'

  return url

for num in range(2, 20):
  url = generateUrl(num)
  print(url)
