#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Fri Jul 24 11:29:01 2020

@author: edi
"""
import codecs
import threading
import time
import pyscreenshot as ImageGrab
from datetime import date
import sqlite3
import json
import WebClient.Http  
import WebClient.Model.Task
import json
import threading
import time
import os, sys, stat
import WebClient.Index
import WebClient.Model.Operations
import config as conf

http=WebClient.Http.Http()
path_files=conf.path_files
failtConected=False



def main(Auth,http):
    base=""
    taskModel=WebClient.Model.Task.Task(conf.host,conf.userBase,conf.userBasePassword,conf.basePort)
    operationModel=WebClient.Model.Operations.Operations(conf.host,conf.userBase,conf.userBasePassword)
    
    Index=WebClient.Index.Index() 
    actions=taskModel.pullFromTheStockQueue()
    for action in actions:
        
        uuid=action["uuid"]
        action_describe=action["action"]
        metadados=action["metadata"]
        
        if action_describe=="PRINT_SCREEN":
            try:
                data=json.loads(metadados)
                path_dest="{}/{}/".format(path_files,data["operation"])
                if os.path.exists(path_dest) == False:
                     os.makedirs(path_dest)
                     os.system("chmod -R 777 {}".format(path_dest))
                     
                     
                               
                imagem = ImageGrab.grab()
                imagem.save(path_dest+str(uuid)+'_screenShot.jpg', 'jpeg')
                print("Foto tirada..")
                taskModel.deleteFromTheStockQueue(uuid)
            except Exception as e:
                print("1-1")
                print(e)
                taskModel.deleteFromTheStockQueue(uuid)
            
        elif(action_describe=="GET_RAW_DATA"):
            try:
                print("Buscando..")
                data=json.loads(metadados)
                Index.createdOperationsDate(userAuth,http,base,data["data"],operationModel)
                #t = threading.Thread(target=Index.createdOperationsDate,args=(userAuth,http,base,data["data"],operationModel,))
                #t.start()
                taskModel.deleteFromTheStockQueue(uuid)
            except Exception as e:
                print("1-2")
                print(e)
                taskModel.deleteFromTheStockQueue(uuid)
                
                
                
        elif(action_describe=="RESET_TO_OPERATIONS"):
                try:
                    print("Resetando..")
                    data=json.loads(metadados)
                    Index.reset_operations(data,operationModel)
                    taskModel.deleteFromTheStockQueue(uuid)
                except Exception as e:
                    print("1-3")
                    print(e)
                    taskModel.deleteFromTheStockQueue(uuid)
                    
        
        

    
    
    

if __name__ == "__main__":
     
     while(True):
         try:
             if failtConected==False:
                     
                  if http.isConectedServer(conf.urlApi):
                         userAuth=http.auth(conf.user["login"],conf.user["psw"])
                         if userAuth["status"]==200:
                             failtConected=True
                           
                         else:
                             print("Tentar novamente..")
                             
                            
                
                
              
             if(failtConected==True):
                 #t = threading.Thread(target=main,args=(userAuth,http))
                 #t.start()
                 main(userAuth,http)
            
             #t = threading.Thread(target=main,args=(userAuth,http,base))
             #t.start()
             time.sleep(1)
         except Exception as e:
             failtConected=False
             print(e)
             
     
     
     
    
     #t = threading.Thread(target=mainThread,args=(userAuth,http,base))
     #t.start()
    
    