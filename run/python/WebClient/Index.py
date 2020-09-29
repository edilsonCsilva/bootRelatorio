 #!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Fri Jul 17 11:14:43 2020

@author: edi
"""

import threading
 
import json
import time
import base64
import WebClient.Libs.Libs as lib
import WebClient.Model.MapFileGenerator
import os
import WebClient.Model.Operations
import config as conf 
import shutil

class Index(object):
    
    def createdOperationsDate(self,Auth,http,db,time_busca,operationModel):
        try:
                    self.auth=Auth
                    self.http=http
                    self.db=db
                    self.operationModel=operationModel
                    self.mapFileGenerator=WebClient.Model.MapFileGenerator.MapFileGenerator(operationModel)
                    self.path_file=conf.path_files_photos  #"fotos"
                    self.path_dest_maps_files=conf.path_files_jsons #  "files"
                    loop=True
                    
                    #self.mapFileGenerator.mapFileGenerator(self.path_dest_maps_files)
                    
                    
                    
                    while(loop):
                        try:
                            print("-------------------------------------")
                            print(time_busca)
                            time_busca_old=time_busca
                            time_data=time_busca.split("/")
                            time_data="{}-{}-{}".format(time_data[2],time_data[1],time_data[0])
                
                            
                            #response=self.http.getOperationsDay(self.auth["data"]["jwt"])
                            response=self.http.getOperationsDayDate(self.auth["data"]["jwt"],time_data)
                            rawObject=json.loads(response)
                            rawObject=rawObject["data"]
                            
                            
                            
                            
                            print(len(rawObject))
                            i=0
                            for op in rawObject:
                                path_dest="{}/{}".format(self.path_dest_maps_files,op["id"])
                                path_dest_photo="{}/{}".format(self.path_file,op["id"])
                                
                                
                                print(str(i)+" - "+  path_dest)
                                i=i+1
                                if os.path.exists(path_dest) == False:
                                     os.makedirs(path_dest)
                                     os.system("chmod -R 777 {}".format(path_dest))
                                     
                                     
                                
                                
                                if os.path.exists(path_dest_photo) == False:
                                     os.makedirs(path_dest_photo)
                                     os.system("chmod -R 777 {}".format(path_dest_photo))
                              
                                
                                
                                delivery_raw={"store_rel":op["store_id"],"area":op["area"],"storeinfo":op["store"]}
                                metadata=base64.b64encode(bytes(json.dumps(op["zonas"]),'utf-8'))
                                photos=self.http.getSearchOperationPhotos(self.auth["data"]["jwt"],op["id"])
                                devices_poits=self.http.getSearchOperationPoits(self.auth["data"]["jwt"],op["id"])
                                
                                photos=json.loads(photos)
                                photos=photos["data"]
                                devices_poits=json.loads(devices_poits)
                                devices_poits=devices_poits["data"]
                                self.operationModel.addPoitsOfTheOperation(op["id"],devices_poits)
                                operacao={
                                        "delivery_id":op["id"],
                                        "status":"N",
                                        "metadata":metadata,
                                        "dt_processing":time_busca_old,
                                        "delivery_raw":json.dumps(delivery_raw)
                                        }
                                if self.operationModel.addOperations(operacao):
                                    for photo in photos:
                                        lib.downloadFile(photo["uri"],"{}/{}".format(self.path_file,op["id"]))
                                        self.operationModel.uploadPhotosOfTheOperation(op["id"],photos)
                                        #p=threading.Thread(target=lib.downloadFile,args=(photo["uri"],"{}/{}".format(self.path_file,op["id"])))
                                        #p.start()
                                        #time.sleep(1)
                                        
                                        
                                   
                                
                            loop=False
                            self.mapFileGenerator.mapFileGenerator(self.path_dest_maps_files)
                            #time.sleep(10)
                            #r=threading.Thread(target=self.mapFileGenerator.mapFileGenerator,args=(self.path_dest_maps_files))
                            #r.start()
                    
                            print("Saindo..!")
                            break
                          
                            
                        except Exception as e:
                            print("1-3")
                            print(e)
                            break
                        
                        break
                    
                    #time.sleep(3)
                        
                        
                    
             
                    
        except Exception as e:
             print(e)
               

    def reset_operations(self,operations,operationModel):
        try:
            operations=operations["operation"].split("|")
            for op_uuid in operations:
                
                if operationModel.resetOperations(op_uuid):
                    try:
                        path_screen="{}/{}".format(conf.path_files,op_uuid)
                        path_files_jsons="{}/{}".format(conf.path_files_jsons,op_uuid)
                        path_files_photos="{}/{}".format(conf.path_files_photos,op_uuid)
                        
                        if os.path.exists(path_screen) == True:
                            shutil.rmtree(path_screen)
                            
                        
                        if os.path.exists(path_files_jsons) == True:
                            shutil.rmtree(path_files_jsons)
                        
                        
                        if os.path.exists(path_files_photos) == True:
                            shutil.rmtree(path_files_photos)
                        
                        
                         
                        print("Ope Removed---> {}".format(op_uuid))
                    except Exception as e:
                        print("1-5")
                        print(e)
                        
                        
                    print("Removido com Sucess")
                    
               
                
           
            
        except Exception as e:
            print(e)
            
            
        
        

    