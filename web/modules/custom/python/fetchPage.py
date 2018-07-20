"""
python3 web/modules/custom/python/fetchPage.py

"""

import requests
import re

from bs4 import BeautifulSoup


# define a class
class RunGetHistData:

  #
  def __init__(self, url):
    self.url = url

  # @param encode = "utf-8"
  def getWebSourceObject(self, encode = "gb2312"):
    requestObj = requests.get(self.url)
    requestObj.encoding = encode

    return requestObj

  #
  def getWebSourceText(self):
    requestObj = self.getWebSourceObject()
    requestObjText = requestObj.text

    # requestObjContent = requestObj.content

    return requestObjText

  #
  def getSoupFromWebSource(self):
    requestObjText = self.getWebSourceText()

    soup = BeautifulSoup(requestObjText, "html.parser")

    return soup

  #
  def getPageTitle(self):
    soup = self.getSoupFromWebSource()
    pageTitle = soup.title.text
    return pageTitle

  #
  def getPageTitle2(self):
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


url = 'http://odds.500.com/fenxi/ouzhi-523156.shtml'

pageTitle = RunGetHistData(url).getPageTitle()

print(pageTitle)


exit()
