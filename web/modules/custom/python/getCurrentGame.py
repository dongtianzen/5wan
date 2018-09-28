"""
python3 web/modules/custom/python/getCurrentGameList.py
http://trade.500.com/sfc/

"""

from FlexJsonClass import FlexJsonBasic
from FetchPageClass import FetchPageBasic
from RunFetchPageClass import RunFetchPageBasic

url = 'http://trade.500.com/sfc/?expect=18120'
gameObj = FetchPageBasic(url)

gameListIds = gameObj.soupCurrentGameListIds()

#
# except Exception: not catch KeyboardInterrupt, SystemExit
for gameId in gameListIds:
  print(gameId)
  try:
    RunFetchPageBasic().runFetch(gameId, 'currentGameList.json', False)
  # except Exception:
  except Exception:
    print("Oops!  That was no valid number.  Try again...")
    pass


exit()
