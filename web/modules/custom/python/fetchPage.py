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
    self.soupGb2312 = self.getSoupFromWebSource('gb2312')

  # @param encode = "utf-8", "gb2312"
  def getWebSourceObject(self, encode = "utf-8"):
    requestObj = requests.get(self.url)
    requestObj.encoding = encode

    return requestObj

  #
  def getWebSourceText(self, encode = "utf-8"):
    requestObj = self.getWebSourceObject(encode)
    requestObjText = requestObj.text

    # requestObjContent = requestObj.content

    return requestObjText

  #
  def getSoupFromWebSource(self, encode = "utf-8"):
    requestObjText = self.getWebSourceText(encode)

    soup = BeautifulSoup(requestObjText, "html.parser")
    return soup

  # @return string, "图卢兹VS雷恩(2015/2016法甲)-百家欧赔-500彩票网"
  def getPageTitle(self):
    pageTitle = self.soupGb2312.title.text

    return pageTitle

  # @return string like "比赛时间2016-02-28 03:00"
  def getGameTime(self):
    gameTimeHtml = self.soupGb2312.find(name = "p", attrs = {"class": "game_time"})
    gameTime = gameTimeHtml.string

    #
    # gameTimeHtmlArray = self.soupGb2312.findAll(name = "p", attrs = {"class": "game_time"})
    # gameTime = gameTimeHtmlArray[0].string

    return gameTime

  # @return string like "比赛时间2016-02-28 03:00"
  def getGameTimeValue(self):
    gameTime = self.getGameTime()

    matchObj = re.search(r"(\d{4}-\d{1,2}-\d{1,2})",gameTime)

    return matchObj.group(0)

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
    print(len(companyList))

    return

  #
  def getGameOddList(self):
    gameOddHtmlArray = self.soup.findAll(name = "td", attrs = {"onclick": "OZ.r(this)"})

    gameOddList = []
    for row in gameOddHtmlArray:
      oddValue = row.string
      oddValue = oddValue.strip()     # filter space

      gameOddList.append(oddValue)

    print(len(gameOddList))
    print((gameOddList))

    return

  #
  def getValueByHtmlTagByHtmlId(self, htmlTag, htmlId):
    output = self.soup.find(name = "td", attrs = {"id": htmlId})

    return output.string

  # @return output is "dict"
  def getPageResultDict(self):
    output = {}
    output['avwinc2']  = self.getValueByHtmlTagByHtmlId('td', 'avwinc2')
    output['avdrawc2'] = self.getValueByHtmlTagByHtmlId('td', 'avdrawc2')
    output['avlostc2'] = self.getValueByHtmlTagByHtmlId('td', 'avlostc2')

    output['avwinj2']  = self.getValueByHtmlTagByHtmlId('td', 'avwinj2')
    output['avdrawj2'] = self.getValueByHtmlTagByHtmlId('td', 'avdrawj2')
    output['avlostj2'] = self.getValueByHtmlTagByHtmlId('td', 'avlostj2')


    # output['pageTitle'] = self.getPageTitle()

    print(output)

    return output

  # --->

# getPageTitle, getGameTime, getGameResult, use this url
url = 'http://odds.500.com/fenxi/ouzhi-523156.shtml'

# getGameOddList and getCompanyList use this url
# url = 'http://odds.500.com/fenxi1/ouzhi.php?id=523156&style=1&start=1&last=1'


gameObj   = RunGetHistData(url)

# gameObj.getPageResultDict()

# pageTitle = gameObj.getPageTitle()
# print(pageTitle)

gameTime  = gameObj.getGameTimeValue()
print(gameTime)

exit()



gameObj.getCompanyList()
gameObj.getGameOddList()

gameObj.getWebSourceText()






