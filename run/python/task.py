#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Tue Aug  4 12:53:37 2020

@author: edi
"""


import threading
import json
import time
import base64
import WebClient.Libs.Libs as lib
import WebClient.Model.MapFileGenerator
import WebClient.Http
import WebClient.Model.Task
import os
import WebClient.Model.Operations
import config as conf 
import shutil
 


http=WebClient.Http.Http()
path_files=conf.path_files
failtConected=False



def main():
       # os.makedirs(conf.path_base)
     taskModel=WebClient.Model.Task.Task(conf.host,conf.userBase,conf.userBasePassword,conf.basePort)
     operationModel=WebClient.Model.Operations.Operations(conf.host,conf.userBase,conf.userBasePassword)
     generateMapFiles=WebClient.Model.MapFileGenerator.MapFileGenerator(operationModel)
     paths_bases=[conf.path_base,conf.path_files,conf.path_files_photos,conf.path_files_jsons]
     for dir_ in paths_bases:
         lib.createdDirSystem(dir_)
                                     
     
     
     if http.isConectedServer(conf.urlApi):
        userAuth=http.auth(conf.user["login"],conf.user["psw"])
      #  print(userAuth["data"]["jwt"])
        time_busca_old=lib.getDateForDays(2)
        print("data Busca: "+time_busca_old)
        operationsDay=http.getOperationsDayDate(userAuth["data"]["jwt"],time_busca_old)
        
      
    
    
        rawObject=json.loads(operationsDay)
        rawObject=rawObject["data"]
        
        
        if len(rawObject) > 0:
            
            for op in rawObject:
                 
                 lib.createdDirSystem("{}/{}".format(conf.path_files_jsons,op["id"]))
                 lib.createdDirSystem("{}/{}".format(conf.path_files_photos,op["id"]))
                 lib.createdDirSystem("{}/{}".format(conf.path_files,op["id"]))
                 delivery_raw={"store_rel":op["store_id"],"area":op["area"],"storeinfo":op["store"]}
                 metadata=base64.b64encode(bytes(json.dumps(op["zonas"]),'utf-8'))
                
                 operacao={
                        "delivery_id":op["id"],
                        "status":"N",
                        "metadata":metadata,
                        "dt_processing":time_busca_old,
                        "delivery_raw":json.dumps(delivery_raw)
                        }
                 
                 if operationModel.addOperations(operacao):
                     print("salvo --Bsca")
                     devices_poits=http.getSearchOperationPoits(userAuth["data"]["jwt"],op["id"])
                     devices_poits=json.loads(devices_poits)
                     devices_poits=devices_poits["data"]
                     operationModel.addPoitsOfTheOperation(op["id"],devices_poits)
                     
                     photos=http.getSearchOperationPhotos(userAuth["data"]["jwt"],op["id"])
                     photos=json.loads(photos)
                     photos=photos["data"]
                     if len(photos) > 0:
                         
                         for photo in photos:
                             try:
                                 lib.downloadFile(photo["uri"],"{}/{}".format(conf.path_files_photos,op["id"]))
                                 operationModel.uploadPhotosOfTheOperation(op["id"],photos)
                                 print(op["id"]+" ["+photo["uri"]+"]"+" -> Fotos Salva")
                             except Exception as e:
                                  print("1-9")
                                  print(e)
                      
                                
                     print(devices_poits)
                     
                      
            print("gerando files")         
            generateMapFiles.mapFileGenerator(conf.path_files_jsons)                  
                      
                 
                
            
   
     
    
    
    
    


if __name__ == "__main__":
    i=0
    while(True):
        try:
            print("Processando [{}]".format(i))
            main()
           
        except Exception as e:
            print("Erro")
            print(e)
            
        time.sleep(1)
        i=i+1
            
            
