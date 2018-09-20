"""
python3 web/modules/custom/python/getCurrentGame.py
http://trade.500.com/sfc/

"""

from FlexJsonClass import FlexJsonBasic
from FetchPageClass import FetchPageBasic
from RunFetchPageClass import RunFetchPageBasic

url = 'http://trade.500.com/sfc/'
gameObj = FetchPageBasic(url)

gameList = gameObj.getCurrentGameIds()
print(gameList)
#
startNum = 171358

#
# except Exception: not catch KeyboardInterrupt, SystemExit
# for num in range(startNum, (startNum + 60)):
#   try:
#     RunFetchPageBasic().runFetch(num)
#   # except Exception:
#   except Exception:
#     print("Oops!  That was no valid number.  Try again...")
#     pass

exit()
