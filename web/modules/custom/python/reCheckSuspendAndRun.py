#!/usr/bin/python3

import os
import os.path
import time

from FlexJsonClass import FlexJsonBasic
from RunFetchPageClass import RunFetchPageBasic

#%%
jsonFilePath = FlexJsonBasic().getGenerateJsonFilePath('downloadGameInfo.json')

fileLastModifiedTimeStamp = os.path.getmtime(jsonFilePath)
currentTimestamp = time.time()
diffTimestamp = currentTimestamp - fileLastModifiedTimeStamp

# startNum < 600594  // end 700000
if(diffTimestamp > 180):
  startNum = FlexJsonBasic().getStartPageIdFromJson()

  if(startNum < 340000):

    # except Exception: not catch KeyboardInterrupt, SystemExit
    for num in range(startNum, (startNum + 1000)):
      try:
        RunFetchPageBasic().runFetch(num)
      # except Exception:
      except Exception:
        print("Oops!  That was no valid number.  Try again...")
        pass
  else:
    print('over the startNum')

else:
  print('time is not enough')


exit()

"""
python3 web/modules/custom/python/reCheckSuspendAndRun.py

# get file creation & modification date/times in Python

"""
