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
    self.soup = self.getSoupFromWebSource()

  # @param encode = "utf-8"
  def getWebSourceObject(self, encode = "gb2312"):
    requestObj = requests.get(self.url)
    requestObj.encoding = encode
    print(24)
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

  # @return string, "图卢兹VS雷恩(2015/2016法甲)-百家欧赔-500彩票网"
  def getPageTitle(self):
    pageTitle = self.soup.title.text
    return pageTitle

  # @return string like "比赛时间2016-02-28 03:00"
  def getGameTime(self):
    gameTimeHtml = self.soup.find(name = "p", attrs = {"class": "game_time"})
    gameTime = gameTimeHtml.string
    #
    gameTimeHtmlArray = self.soup.findAll(name = "p", attrs = {"class": "game_time"})
    gameTime = gameTimeHtmlArray[0].string

    return gameTime

  # @return string like "3:2"
  def getGameResult(self):
    gameResultHtml = self.soup.find(name = "p", attrs = {"class": "odds_hd_bf"})
    gameResult = gameResultHtml.string

    return gameResult

  #
  def getCompanyList(self):
    companyHtmlArray = self.soup.findAll(name = "span", attrs = {"class": "quancheng"})

    companyList = []
    for row in companyHtmlArray:
      companyName = row.string
      companyName = companyName.strip()     # filter space

      companyList.append(companyName)

    print(companyList)

    return

  #
  def getGameOddList(self):
    gameOddHtmlArray = self.soup.findAll(name = "td", attrs = {"onclick": "OZ.r(this)"})

    gameOddList = []
    for row in gameOddHtmlArray:
      oddValue = row.string
      oddValue = oddValue.strip()     # filter space

      gameOddList.append(oddValue)

    print(gameOddList)

    return


url = 'http://odds.500.com/fenxi/ouzhi-523156.shtml'

gameObj = RunGetHistData(url)
pageTitle = gameObj.getPageTitle()
gameTime  = gameObj.getGameTime()

print(pageTitle)
print(gameTime)
print(gameObj.getCompanyList())


exit()
