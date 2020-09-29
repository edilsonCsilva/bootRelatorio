#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Fri Jul 24 11:29:01 2020

@author: edi
"""
 
import threading
import time
import pyscreenshot as ImageGrab
from datetime import date
import sqlite3
import json
import WebClient.Http  
import WebClient.Db.Mysql
import json
import threading
import time
import os
import WebClient.Db.Base
import WebClient.Index


urlApi="http://localhost/stillBootOperacionalApi/requests"
user={"login":"edilsonclaudinosilva@gmail.com","psw":"1"}
http=WebClient.Http.Http()
base=WebClient.Db.Base.Base()
userAuth="{}"
path_files="print_screen"




def main(Auth,http,db):
    Index=WebClient.Index.Index() 
    actions=getAction()
    for action in actions:
        uuid=action[0]
        action_describe=action[1]
        metadados=action[2]
        
        if action_describe=="PRINT_SCREEN":
            try:
                data=json.loads(metadados)
                path_dest="{}/{}/".format(path_files,data["operation"])
                if os.path.exists(path_dest) == False:
                     os.makedirs(path_dest)
                               
                imagem = ImageGrab.grab()
                imagem.save(path_dest+str(uuid)+'_screenShot.jpg', 'jpeg')
                print("Foto tirada..")
                delAction(uuid)
            except Exception as e:
                print(e)
                delAction(uuid)
            
        elif(action_describe=="GET_RAW_DATA"):
            try:
                data=json.loads(metadados)
                #time_data=data["data"].split("/")
                #time_data="{}-{}-{}".format(time_data[2],time_data[1],time_data[0])
                print(data)
                
                
                Index.createdOperationsDate(userAuth,http,base,data["data"])
                delAction(uuid)
            except Exception as e:
                print(e)
                delAction(uuid)
                
        
        


def mainThread(Auth,http,db):
    Index=WebClient.Index.Index() 
    actions=getAction()
    while(True):
        
        for action in actions:
            uuid=action[0]
            action_describe=action[1]
            metadados=action[2]
            
            if action_describe=="PRINT_SCREEN":
                try:
                    data=json.loads(metadados)
                    path_dest="{}/{}/".format(path_files,data["operation"])
                    if os.path.exists(path_dest) == False:
                         os.makedirs(path_dest)
                                   
                    imagem = ImageGrab.grab()
                    imagem.save(path_dest+str(uuid)+'_screenShot.jpg', 'jpeg')
                    print("Foto tirada..")
                    delAction(uuid)
                except Exception as e:
                    print(e)
                    delAction(uuid)
                
            elif(action_describe=="GET_RAW_DATA"):
                try:
                    data=json.loads(metadados)
                    #time_data=data["data"].split("/")
                    #time_data="{}-{}-{}".format(time_data[2],time_data[1],time_data[0])
                    print(data)
                    
                    
                    Index.createdOperationsDate(userAuth,http,base,data["data"])
                    delAction(uuid)
                except Exception as e:
                    print(e)
                    delAction(uuid)
                    
                    
        
        time.sleep(1)                
                
   

        

        
        
        
    
    
    
    
def getAction():
        actions=[]
        try:
            
            conn =sqlite3.connect('controler.db')
            cur = conn.cursor()
            cur.execute("SELECT ObjId, descricao,metadados FROM settings")
            for row in cur:
                actions.append(row)
                
            conn.close()
            
            

        except Exception as e:
             pass
           
        return actions
    
    
    
def delAction(uuid):
        try:
           
            conn =sqlite3.connect('controler.db')
            cur = conn.cursor()
            cur.execute("delete  FROM settings where ObjId ="+str(uuid)+"")
            conn.commit()
            conn.close()
            number_of_rows=cur.rowcount
            return number_of_rows
            
        except Exception as e:
            print(e)
            return False   
        

if __name__ == "__main__":
     conn = sqlite3.connect('controler.db')
     cur = conn.cursor()
     sql='CREATE TABLE IF NOT EXISTS settings( ObjId INTEGER PRIMARY KEY AUTOINCREMENT,   descricao TEXT  , metadados TEXT);'
     cur.execute(sql)
     #sql='insert into settings(descricao, metadados) values("PRINT_SCREEN","F")'
     #cur.execute(sql)
     #conn.commit()
     conn.close()
     
     if http.isConectedServer(urlApi):
         userAuth=http.auth(user["login"],user["psw"])
         if userAuth["status"]==200:
           #  WebClient.Index.Index(userAuth,http,base)
           pass
         else:
             print("Tentar novamente..")
             
             
             
     
     while(True):
         try:
             main(userAuth,http,base)
             #t = threading.Thread(target=main,args=(userAuth,http,base))
             #t.start()
             time.sleep(1)
         except Exception as e:
             pass
     
     
     
    
     #t = threading.Thread(target=mainThread,args=(userAuth,http,base))
     #t.start()
    
    