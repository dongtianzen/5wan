"""
python3 web/modules/custom/python/debug_basic.py

"""

from BaseSiteClass import Baseinfo

print(888)
for num in range(520000, 520002):
  url = Baseinfo().generateUrl(num)
  print(url)

