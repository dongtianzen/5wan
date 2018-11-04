"""
python3 web/modules/custom/python/getCurrentGameList.py
http://trade.500.com/sfc/

"""

from FetchPageClass import FetchPageBasic
from RunFetchPageClass import RunFetchPageBasic

url = 'http://trade.500.com/jczq/?playid=269'
gameObj = FetchPageBasic(url)

gameListIds = gameObj.soupCurrentGameListIds()

#
# except Exception: not catch KeyboardInterrupt, SystemExit
for gameId in gameListIds:
  print(gameId)
  try:
    RunFetchPageBasic().runFetch(gameId, 'currentJingCaiList.json', False, basicFields = True)
  # except Exception:
  except Exception:
    print("Oops!  That was no valid number.  Try again...")
    pass


exit()
