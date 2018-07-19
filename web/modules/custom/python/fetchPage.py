"""
python3 web/modules/custom/python/fetchPage.py

"""

import requests
import re
from bs4 import BeautifulSoup


url = 'http://odds.500.com/fenxi/europe_xls.php?fixtureid=736666'
request = requests.get(url)
print(request.url)
print(request.text)
