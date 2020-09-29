#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Mon Jul 27 08:45:37 2020

@author: edi
"""

import WebClient.Db.Mysql 
import WebClient.Model.Operations


"""
Db=WebClient.Db.Mysql.Mysql("localhost","still","still")
Db.setTheStockQueue("PRINT_SCREEN","{}")
D=Db.pullFromTheStockQueue()
for f in D:
    print(f)
    #Db.deleteFromTheStockQueue(f["uuid"])

"""
operacao={
          "delivery_id":"1234",
          "status":"N",
          "metadata":"ddd",
          "dt_processing":"25/2/2/2",
                                        
                                        }
 
 
Db=WebClient.Model.Operations.Operations("localhost","still","still")
Db.addOperations(operacao)






print("d")  