"""
python3 web/modules/custom/python/pymongo/runCheckDuplication.py

"""

#!/usr/bin/python3
import logging
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
  def executeFindCommand(self, queryObj):
    doc = self.getCollection().find(queryObj)
    return doc

  ###
  def executeFindCountCommand(self, queryObj):
    doc = self.getCollection().find(queryObj).count()
    return doc

  ###
  def runFindCountCommand(self):
    logging.basicConfig(filename = 'logfilename.log', level = logging.WARNING)
      # filemode = 'a'
      # datefmt = '%H:%M:%S',
      # format = '%(asctime)s,%(msecs)d %(name)s %(levelname)s %(message)s',

    logging.warning("Running Urban warning")

    for num in range(100000, 100010):
      queryObj = { "id5": num }

      if ((num % 1000) == 0):
        print(num)

      result = self.executeFindCountCommand(queryObj)
      if (result > 1):
        print('find ' + str(num) + ' have ' + str(result))
  ###

  ###
  def runFindCommand(self):
    for num in range(520021, 520025):
      queryObj = { "id5": num }

      doc = self.executeFindCountCommand(queryObj)

      for x in doc:
        print(x)

  ###
BasicQueryPyMongo().runFindCountCommand()
