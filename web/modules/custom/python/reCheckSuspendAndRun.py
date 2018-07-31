"""
python3 web/modules/custom/python/reCheckSuspendAndRun.py

# get file creation & modification date/times in Python

"""

from FetchPageClass import FetchPageBasic
from FlexJsonClass import FlexJsonBasic

import os
import os.path
import time

jsonFilePath = FlexJsonBasic().getGenerateJsonFilePath('downloadGameInfo.json')

fileLastModifiedTimeStamp = os.path.getmtime(jsonFilePath)
currentTimestamp = time.time()

print(fileLastModifiedTimeStamp)
print(currentTimestamp)

diffTimestamp = currentTimestamp - fileLastModifiedTimeStamp
print(diffTimestamp)

if(diffTimestamp > 300):
  print(9999)
