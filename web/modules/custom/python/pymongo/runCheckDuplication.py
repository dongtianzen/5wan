"""
python3 web/modules/custom/python/pymongo/runCheckDuplication.py

"""

#!/usr/bin/python3

import pymongo

myclient = pymongo.MongoClient("mongodb://localhost:27017/")
mydb = myclient["5wan"]
myCollection = mydb["game"]

myquery = { "id5": "520021" }

mydoc = mycol.find(myquery)

for x in mydoc:
  print(x)
