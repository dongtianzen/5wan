"""
python3 web/modules/custom/python/fetchPage.py

"""

import requests
import re

from bs4 import BeautifulSoup


# @param encode = "utf-8"
# print(requestObj.url)
# print(requestObj.text)
#
def getWebSource(url, encode="gb2312"):
  requestObj = requests.get(url)
  requestObj.encoding = encode

  return requestObj


#
def convertWebSourceToList(requestObj):
  requestObjText = requestObj.text

  soup = BeautifulSoup(requestObj.text, "html.parser")

  pageTitle = soup.title.text
  pageTitle = soup.title.text

  gameTimeHtml = soup.find(name = "p", attrs = {"class": "game_time"})
  gameTimeHtmlArray = soup.findAll(name = "p", attrs = {"class": "game_time"})

  print(pageTitle)

  print(gameTimeHtml.string)
  print(gameTimeHtmlArray[0].string)

  return pageTitle


url = 'http://odds.500.com/fenxi/ouzhi-523656.shtml'
requestObj = getWebSource(url)

convertWebSourceToList(requestObj)






exit()
