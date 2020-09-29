#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Tue Jul 21 09:35:48 2020

@author: edi
"""

import json
import threading
import time
import os, sys
import requests
import config as conf
import datetime




def createdDirSystem(paths):
      if os.path.exists(paths) == False:
         os.makedirs(paths,777)
         
         

def getDateForDays(day):
    date_now = datetime.datetime.now()
    seven_days_ago = date_now - datetime.timedelta(days=day)
    return  seven_days_ago.strftime("%Y-%m-%d")



def downloadFile(url_file,path_dest):
    try:
        headers = {
                'user-agent': conf.USER_AGENT2,'token-acess':conf.DB_KEY_ACESS_LOGIN
                
                }

        if os.path.exists(path_dest) == False:
            os.makedirs(path_dest)
            
        photo_split=url_file.split("/")
        with open("{}/{}".format(path_dest,photo_split[len(photo_split)-1]), 'wb') as file:
            resposta = requests.get(url_file,headers=headers, stream=True)
            
            if not resposta.ok:
                print("Ocorreu um erro, status:" , resposta.status_code)
                return False
            else:
                for dado in resposta.iter_content(1024):
                    if not dado:
                        break
                    
                    file.write(dado)
                
        
        
    except Exception as e:
        print("1-7")
        print(e)
