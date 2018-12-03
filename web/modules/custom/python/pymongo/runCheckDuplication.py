"""
python3 web/modules/custom/python/pymongo/runCheckDuplication.py

"""

#!/usr/bin/python3

import pymongo

dbClient = pymongo.MongoClient("mongodb://localhost:27017/")
database = dbClient["5wan"]
dbCollection = database["game"]

queryObj = { "id5": 520021 }

mydoc = dbCollection.find(queryObj)

for x in mydoc:
  print(x)

#%%
# define a class
class BasicQueryPyMongo:

  ###
  def getDbClient(self):
    dbClient = pymongo.MongoClient("mongodb://localhost:27017/")
    return dbClient
  ###
  def getDatabase(self):
    database = self.getDbClient()["5wan"]
    return database

  ###
  def getCollection(self):
    dbCollection = self.getDatabase()["game"]
    return dbCollection

  ###
  def runFindCommand(self):
    queryObj = { "id5": 520021 }

    mydoc = self.getCollection().find(queryObj)

    for x in mydoc:
      print(x)
