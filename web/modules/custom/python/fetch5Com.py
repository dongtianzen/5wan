"""
python3 web/modules/custom/python/fetch5Com.py

"""

from FlexJsonClass import FlexJsonBasic
from RunFetchPageClass import RunFetchPageBasic

#%%
#

# start from 500000
# end   to   700000
startNum = 500000
startNum = FlexJsonBasic().getStartPageIdFromJson()
startNum = 24910

#
# except Exception: not catch KeyboardInterrupt, SystemExit
for num in range(startNum, (startNum + 80)):
  try:
    RunFetchPageBasic().runFetch(num)
  # except Exception:
  except Exception:
    print("Oops!  That was no valid number.  Try again...")
    pass

exit()
