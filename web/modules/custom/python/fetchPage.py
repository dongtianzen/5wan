"""
python3 web/modules/custom/python/fetchPage.py

"""

import requests
import re
from bs4 import BeautifulSoup


url = 'http://odds.500.com/fenxi/ouzhi-736656.shtml'
requestObj = requests.get(url)
requestObj.encoding = 'utf-8'
print(requestObj.url)

exit()
print(requestObj.text)
