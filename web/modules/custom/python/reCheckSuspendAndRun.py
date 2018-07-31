"""
python3 web/modules/custom/python/reCheckSuspendAndRun.py

# get file creation & modification date/times in Python

"""

from FetchPageClass import FetchPageBasic
from FlexJsonClass import FlexJsonBasic

import os
import os.path
import time
import platform

jsonFilePath = FlexJsonBasic().getGenerateJsonFilePath('downloadGameInfo.json')


print("last modified: %s" % time.ctime(os.path.getmtime(jsonFilePath)))
print("created: %s" % time.ctime(os.path.getctime(jsonFilePath)))
