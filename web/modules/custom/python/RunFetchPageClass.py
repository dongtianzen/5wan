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

  def runFetch(self, num):
    jsonFilePath = FlexJsonBasic().getGenerateJsonFilePath('downloadGameInfo.json')

    url = Baseinfo().generateUrl(num)
    print(url)

    ## Page Result
    gameObj = FetchPageBasic(url)

    try:
      jsonContentFromFile = FlexJsonBasic().readJsonContent(jsonFilePath)
      jsonContentFromFile[num] = gameObj.convertPageResultDict()
    except:
      pass

    jsonContent = pd.DataFrame.from_dict(jsonContentFromFile)

    FlexJsonBasic().generateJsonFromData(jsonFilePath, jsonContent)


    ## page Id
    pageIdJsonContent = { "id" : num}

    pageIdJsonContentDataFrame = pd.DataFrame.from_dict(pageIdJsonContent, orient = 'index')
    FlexJsonBasic().generateJsonForPageId(pageIdJsonContentDataFrame)

    return

  #%%

