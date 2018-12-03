"""
python3 web/modules/custom/python/pymongo/runCheckDuplication.py

"""

#!/usr/bin/python3

import pymongo
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
  def executeFindCommand(queryObj):
    doc = self.getCollection().find(queryObj)
    return doc

  ###
  def runFindCommand(queryObj):
    for num in range(520021, 520025):
      queryObj = { "id5": num }

      doc = = self.executeFindCommand(queryObj)

      for x in doc:
        print(x)

  ###
BasicQueryPyMongo().runFindCommand()
