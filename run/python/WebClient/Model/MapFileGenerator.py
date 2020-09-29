#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Wed Jul 22 12:25:54 2020

@author: edi
"""

# -*- coding: utf-8 -*-
import sqlite3
import json
import base64
import WebClient.Model
import os


class MapFileGenerator(object):
    
    def __init__(self,operationModel):
        self.operation=operationModel
    
    def mapFileGenerator(self,path_file):
        
        try:
            operations=self.operation.getOperationsNotStaticFile()
            for operation in operations:
                #arq = open("{}/{}.json".format(path_file,operation[1]), 'w')
                path_dest="{}/{}".format(path_file,operation[1])
                if os.path.exists(path_dest) == False:
                    os.makedirs(path_dest)
                                

                map_model={"points":[],"zonas":[]}
                arq = open("{}/{}.json".format(path_dest,operation[1]), 'w')
                devivery_coods=self.operation.getOperationsNotStaticFilePoits(operation[1])
                if (len(devivery_coods) > 0):
                    try:
                        coods=json.loads(base64.b64decode(devivery_coods[0][2]))
                        map_model["points"].append(coods)
                    except Exception as e:
                        print("map-1-1")
                        print(e)
                        
                
                decode=json.loads(base64.b64decode(operation[5]))
                if len(decode) > 0 :
                    try:
                        for zn in decode:
                            zn_split=zn["content"].split("|")
                            for zn_a in zn_split:
                                lat_log=zn_a.split(",")
                                map_model["zonas"].append({"lat":lat_log[0],"lon":lat_log[1]})
                                #print("s")
                               
                    except Exception as e:
                        print("map-1-2")
                        print(e)
                        

                arq.write(json.dumps(map_model))
                arq.close()    
                self.operation.updateOperations(operation[1])
                #break
            
            
        except Exception as e:
            print("map-1-2")
            print(e)
            
            
            
        