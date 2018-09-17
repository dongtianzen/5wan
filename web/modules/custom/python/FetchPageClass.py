"""
python3 web/modules/custom/python/fetchPage.py

"""

import random
import requests
import re

from bs4 import BeautifulSoup


# define a class
class FetchPageBasic:

  #
  # 使用BeautifulSoup解析gb2312的网页，指定了编码为gb2312时仍然有部分页面获取到的是乱码，我测试发现返回的
  # originalEncoding为windows-1252
  # 请注意 gb2312 不是 “gb2312”，
  # 凡 gb2312 的请换成 gb18030.
  # 微软将 gb2312 和 gbk 映射为 gb18030，方便了一些人，也迷惑了一些人。
  def __init__(self, url):
    self.url = url
    self.soup       = self.getSoupFromWebSource()
    self.soupGb2312 = self.getSoupFromWebSource('gb18030')

  # 伪造 X-Forwarded-For
  def getForwardedHeader(self):
    ip_address = ['125.92.32.81', '125.92.32.82', '125.92.32.83']

    headers = {"Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
               "Accept-Encoding": "gzip, deflate",
               "Accept-Language": "zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3",
               "Connection": "keep-alive",
               "X-Forwarded-For": ip_address[random.randint(0, len(ip_address) - 1)],
               "Content-Length": "31",
               "Content-Type": "application/x-www-form-urlencoded",
               "User-Agent": "Mozilla/5.0 (Windows NT 5.1; rv:11.0) Gecko/20100101 Firefox/11.0"}

    return headers

  # @param encode = "utf-8", "gb2312"
  def getWebSourceObject(self, encode = "utf-8"):
    requestObj = requests.get(self.url)
    # requestObj = requests.get(self.url, self.getForwardedHeader())
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
  def soupPageTitle(self):
    pageTitle = self.soupGb2312.title.text

    return pageTitle

  # @return string like "比赛时间2016-02-28 03:00"
  def soupGameTimeInfo(self):
    gameTimeHtml = self.soupGb2312.find(name = "p", attrs = {"class": "game_time"})
    gameTime = gameTimeHtml.string

    #
    # gameTimeHtmlArray = self.soupGb2312.findAll(name = "p", attrs = {"class": "game_time"})
    # gameTime = gameTimeHtmlArray[0].string

    return gameTime

  # @return string like "3:2"
  def soupGameResult(self):
    gameResultHtml = self.soupGb2312.find(name = "p", attrs = {"class": "odds_hd_bf"})
    gameResult = gameResultHtml.string

    return gameResult

  # @return string like "图卢兹,雷恩,图卢兹VS雷恩赔率,2015/2016法甲"
  def soupMetaKeywords(self):
    metaKeywords = None

    metaResult = self.soupGb2312.find_all(name = "meta", attrs = {"name": "Keywords"})

    for tag in metaResult:
      if 'name' in tag.attrs.keys() and tag.attrs['name'].strip().lower() in ['description', 'keywords']:
        metaKeywords = (tag.attrs['content'])

    return metaKeywords

  # @return string like "2016-02-28"
  def obtainGameDate(self):
    gameTimeInfo = self.soupGameTimeInfo()
    matchDateObj = re.search(r"(\d{4}-\d{1,2}-\d{1,2})", gameTimeInfo)

    return matchDateObj.group(0)

  # @return string like "2016-02-28T03:00"
  def obtainGameDateAndTime(self):
    gameTimeInfo = self.soupGameTimeInfo()
    matchDateObj = re.search(r"(\d{4}-\d{1,2}-\d{1,2})", gameTimeInfo)
    matchTimeObj = re.search(r"(\d{2}:\d{2})", gameTimeInfo)

    output = matchDateObj.group(0) + 'T' + matchTimeObj.group(0) + ':00'

    return output

  # Game Score
  def obtainGameResultList(self):
    gameResult = self.soupGameResult()

    # 有时候有赔率，但是没有比赛结果, 会返回“VS”， length 为 1
    if gameResult:
      return gameResult.split(':')
    else:
      return None

  #
  def obtainGameTitleList(self):
    gameTitle = self.soupMetaKeywords()
    gameTitleList = gameTitle.split(',')

    return gameTitleList

  #
  def filterGameTag(self):
    # '2015/2016英冠', or '2018世界杯'
    gameYearTag = self.obtainGameTitleList()[3]

    # remove 数字和反斜线部分
    gameTag = re.sub("\/\d{4}", '', gameYearTag)
    gameTag = re.sub("\d{4}", '', gameTag)

    return gameTag

  #
  def findCompanyList(self):
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
  def findGameOddList(self):
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
  def findValueByHtmlTagByHtmlId(self, htmlTag, htmlId):
    output = self.soup.find(name = htmlTag , attrs = {"id": htmlId})

    # check html is not empty
    if output:
      return output.string
    else:
      return None

  # @return output is "dict"
  def convertPageResultDict(self):
    output = {}

    iniWinValue = self.findValueByHtmlTagByHtmlId('td', 'avwinc2')

    # check html value is not empty
    if iniWinValue:
      if len(self.obtainGameResultList()) > 1:
        # output['ini_win']  = iniWinValue
        # output['ini_draw'] = self.findValueByHtmlTagByHtmlId('td', 'avdrawc2')
        # output['ini_loss'] = self.findValueByHtmlTagByHtmlId('td', 'avlostc2')

        # output['ave_win']  = self.findValueByHtmlTagByHtmlId('td', 'avwinj2')
        # output['ave_draw'] = self.findValueByHtmlTagByHtmlId('td', 'avdrawj2')
        # output['ave_loss'] = self.findValueByHtmlTagByHtmlId('td', 'avlostj2')

        output['variation_ini_win']  = self.findValueByHtmlTagByHtmlId('td', 'lswc2')
        output['variation_ini_draw'] = self.findValueByHtmlTagByHtmlId('td', 'lsdc2')
        output['variation_ini_loss'] = self.findValueByHtmlTagByHtmlId('td', 'lslc2')

        output['variation_end_win']  = self.findValueByHtmlTagByHtmlId('td', 'lswj2')
        output['variation_end_draw'] = self.findValueByHtmlTagByHtmlId('td', 'lsdj2')
        output['variation_end_loss'] = self.findValueByHtmlTagByHtmlId('td', 'lslj2')

        # output['num_company'] = self.findValueByHtmlTagByHtmlId('span', 'nowcnum')

        # output['goal_home'] = self.obtainGameResultList()[0]
        # output['goal_away'] = self.obtainGameResultList()[1]

        output['name_home'] = self.obtainGameTitleList()[0]
        output['name_away'] = self.obtainGameTitleList()[1]

        # output['tags']  = self.filterGameTag()

        # output['date_time'] = self.obtainGameDateAndTime()

    return output

  #%%
