"""
python3 web/modules/custom/python/RunFetchPageClass.py

"""

import pandas as pd

from BaseSiteClass import Baseinfo
from FetchPageClass import FetchPageBasic
from FlexJsonClass import FlexJsonBasic

#%%
#
class RunFetchPageBasic:

  #
  def runFetch(self, gameId, jsonFileName = 'downloadGameInfo.json', updateStartPageId = True):
    gameInfoJsonFilePath = FlexJsonBasic().getGenerateJsonFilePath(jsonFileName)

    url = Baseinfo().generateUrl(gameId)
    print(url)

    ## Page Result
    gameObj = FetchPageBasic(url)

    try:
      jsonContentFromFile = FlexJsonBasic().readJsonContent(gameInfoJsonFilePath)
      jsonContentFromFile[gameId] = gameObj.convertPageResultDict()
    except:
      pass

    jsonContent = pd.DataFrame.from_dict(jsonContentFromFile)
    FlexJsonBasic().generateJsonFromData(gameInfoJsonFilePath, jsonContent)


    ## start page Id
    if bool(updateStartPageId):
      startPageIdJsonContent = { "id" : gameId}
      startPageIdJsonContentDataFrame = pd.DataFrame.from_dict(startPageIdJsonContent, orient = 'index')
      FlexJsonBasic().generateJsonForPageId(startPageIdJsonContentDataFrame)

    return

  #%%

