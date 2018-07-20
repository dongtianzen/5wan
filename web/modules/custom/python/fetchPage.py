"""
python3 web/modules/custom/python/fetchPage.py

"""

import requests
import re

from bs4 import BeautifulSoup


# define a class
class RunGetHistData:
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
  # requestObjText = requestObj.content

  soup = BeautifulSoup(requestObj.text, "html.parser")

  #
  pageTitle = soup.title.text

  #
  gameTimeHtml = soup.find(name = "p", attrs = {"class": "game_time"})
  gameTime = gameTimeHtml.string
  #
  gameTimeHtmlArray = soup.findAll(name = "p", attrs = {"class": "game_time"})
  gameTime = gameTimeHtmlArray[0].string

  #
  gameResultHtml = soup.find(name = "p", attrs = {"class": "odds_hd_bf"})
  gameResult = gameResultHtml.string

  #
  gameOddHtmlArray = soup.findAll(name = "td", attrs = {"onclick": "OZ.r(this)"})

  gameOddList = []
  for row in gameOddHtmlArray:
    oddValue = row.string.strip()
    oddValue = oddValue.strip()     # filter space

    gameOddList.append(oddValue)

  print(gameOddList)

  return


url = 'http://odds.500.com/fenxi/ouzhi-523656.shtml'
requestObj = getWebSource(url)

print('1123456789')
convertWebSourceToList(requestObj)






exit()
