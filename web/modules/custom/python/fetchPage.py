"""
python3 web/modules/custom/python/fetchPage.py

"""

import requests
import re
from bs4 import BeautifulSoup


# @param encode = "utf-8"
def getWebSource(url, encode="gb2312"):
  requestObj = requests.get(url)
  requestObj.encoding = encode

  return requestObj
  return requestObj.text

url = 'http://odds.500.com/fenxi/ouzhi-736656.shtml'
requestObj = getWebSource(url)

print(requestObj.url)
print(requestObj.text)




exit()
