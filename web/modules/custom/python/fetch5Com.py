"""
python3 web/modules/custom/python/fetch5Com.py

"""

from FlexJsonClass import FlexJsonBasic
from RunFetchPageClass import RunFetchPageBasic

#%%
#

# start from 520000
# start from 600594
startNum = 500000
startNum = FlexJsonBasic().getStartPageIdFromJson()

#
# except Exception: not catch KeyboardInterrupt, SystemExit
for num in range(startNum, (startNum + 1000)):
  try:
    RunFetchPageBasic().runFetch(num)
  # except Exception:
  except Exception:
    print("Oops!  That was no valid number.  Try again...")
    pass

exit()
