"""
# python3 web/modules/custom/python/FlexJsonClass.py

"""
import json
import time
import urllib.request

from pathlib import Path

#%%
# define a class
class FlexJsonBasic:

  #
  def readJsonContent(self, urlPath):
    jsonFile = open(urlPath, "r") # Open the JSON file for reading
    output = json.load(jsonFile)  # Read the JSON into the buffer
    jsonFile.close()              # Close the JSON file

    time.sleep(0.01)

    return output

  #
  # @return output type is list
  def readJsonDecode(self, urlPath):
    with urllib.request.urlopen(urlPath) as url:
      output = json.loads(url.read().decode())

    return output

  #
  def generateJsonForPageId(self, jsonData):
    filePath = self.getGenerateJsonFilePath('startPageId.json')

    self.generateJsonFromData(filePath, jsonData)

    return

  #
  # use pandas.DataFrame.to_json 生成Json格式的文件
  # @param jsonData is require as <class 'pandas.core.frame.DataFrame'>
  # orient = 'columns' or orient = 'index' is 不同转换数组List排序方法
  def generateJsonFromData(self, filePath, jsonData):
    jsonData.to_json(filePath, orient = 'columns')

    print ('JSON generate success')
    return

  # Just open the file with its "full path" directly
  def getGenerateJsonFilePath(self, fileName):
    # 运行文件从server or local command line, 在当前Repository下
    pathDir  = 'web/sites/default/files/json/5wan/'
    pathDirObject = Path(pathDir)

    if pathDirObject.is_dir():
      filePath = pathDir + fileName
      return filePath

    # 运行文件从Drupal file or Devel or PHP , 要使用当前系统下的完全路径
    pathDir = '/Applications/MAMP/htdocs/5wan/web/sites/default/files/json/5wan/'
    pathDirObject = Path(pathDir)

    if pathDirObject.is_dir():
      print('is exist from PHP')
      filePath = pathDir + fileName
      return filePath

    # 运行文件从Server Cron command，所以要服务器上的绝对路径
    pathDir = '/var/www/html/5wan/web/sites/default/files/json/5wan/'
    pathDirObject = Path(pathDir)

    if pathDirObject.is_dir():
      print('is exist from Ubuntu Server')
      filePath = pathDir + fileName
      return filePath

    return

  #
  def getStartPageIdFromJson(self):
    pageIdJsonFilePath = self.getGenerateJsonFilePath('startPageId.json')
    pageIdJsonContent = self.readJsonContent(pageIdJsonFilePath)

    startNum = pageIdJsonContent["0"]["id"]

    return startNum

  #%%
