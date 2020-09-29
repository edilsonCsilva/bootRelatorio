# -*- coding: utf-8 -*-
"""
Spyder Editor

Este é um arquivo de script temporário.
"""

import WebClient.Http  
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
def runApp(params):
    
    while(True):
        try:
            if http.isConectedServer(urlApi):
                userAuth=http.auth(user["login"],user["psw"])
                if userAuth["status"]==200:
                   WebClient.Index.Index(userAuth,http,base);
                else:
                    print("Tentar novamente..")
                    time.sleep(10)
                    
            break
                
        except Exception as e:
             print("Error .. Usuario ou Servidor")
             print(e)
             time.sleep(1)
            
        
    
     
   


if __name__ == "__main__":
    
    
    if http.isConectedServer(urlApi):
         userAuth=http.auth(user["login"],user["psw"])
         if userAuth["status"]==200:
             WebClient.Index.Index(userAuth,http,base)
         else:
             print("Tentar novamente..")
             
        
   # app = threading.Thread(target=runApp,args=({},))
   # app.start()
    
   
    


   
 
 