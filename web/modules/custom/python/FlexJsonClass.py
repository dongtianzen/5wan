"""
# python3 web/modules/custom/python/FlexJsonClass.py

"""
import json
import urllib.request

from pathlib import Path


# define a class
class FlexJsonBasic:

  # @return output type is list
  def readJsonDecode(self, urlPath):
    with urllib.request.urlopen(urlPath) as url:
      output = json.loads(url.read().decode())

    return output

  # 生成Json格式的文件
  # @param jsonData is <class 'pandas.core.frame.DataFrame'>
  def generateJsonFromData(self, filePath, jsonData):
    jsonData.to_json(filePath, orient='index')

    print ('JSON generate success')
    return


  def getGenerateJsonFilePath(self, fileName):
    # 运行文件从command line
    pathDir  = 'web/sites/default/files/json/5wan/'
    pathDirObject = Path(pathDir)

    if pathDirObject.is_dir():
      print('is exist from command line')
      filePath = pathDir + fileName
      return filePath

    # 运行文件从Drupal file or Devel or PHP , 要使用当前系统下的完全路径
    pathDir = '/Applications/MAMP/htdocs/5wan/web/sites/default/files/json/5wan/'
    pathDirObject = Path(pathDir)

    if pathDirObject.is_dir():
      print('is exist from PHP')
      filePath = pathDir + fileName
      return filePath

    return
