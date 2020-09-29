#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Thu Jul 16 14:53:37 2020

@author: edi
"""
import requests
import json
import config as conf
 

headers = {
        'user-agent': conf.USER_AGENT,'token-acess':conf.DB_KEY_ACESS_LOGIN
        
        }


class Http(object):
    
    def isConectedServer(self,url):
        try:
            r = requests.get(url+'/status',headers=headers)
          
            response=json.loads(r.text)
            
            if int(response["status"])==200:
                self.url=url
                return True
            else:
                return False
        except Exception as e:
            print(e)
            return False
        
        
        
    def auth(self,user,passw):
        try:
            payload = {'user': user, 'password': passw}
            headers["content-type"]="application/x-www-form-urlencoded"
            response = requests.post(self.url+'/oauth',data=payload,headers=headers)
            response= json.loads(response.text) 
            if response["status"]==200:
                return response
            else:
                return {}
            
        except:
            return -1


    def getOperationsDay(self,jwt):
        try:
            headers["content-type"]="application/json; charset=utf-8"
            headers["token-acess"]=jwt
            response = requests.get(self.url+'/getOperationsDay',headers=headers)
            
            return response.text 
        
        except:
            return "{}"
        
        
        
    def getOperationsDayDate(self,jwt,data):
        try:
            headers["content-type"]="application/json; charset=utf-8"
            headers["token-acess"]=jwt
            payload = {'data':data}
            data=json.dumps(payload)
            response = requests.get(self.url+'/getOperationsDayDate',data=data,headers=headers)
            return response.text 
        
        except:
            return "{}"
        
        
        
    
    def getSearchOperationPhotos(self,jwt,uuid_operation):
        try:
            headers["content-type"]="application/json; charset=utf-8"
            headers["token-acess"]=jwt
            payload = {'delivery':uuid_operation}
            response = requests.get(self.url+'/getSearchOperationPhotos',data=json.dumps(payload),headers=headers)
            return response.text 
        
        except Exception as e:
             print(e)
             return "{}"
         
    def getSearchOperationPoits(self,jwt,uuid_operation):
        try:
            headers["content-type"]="application/json; charset=utf-8"
            headers["token-acess"]=jwt
            payload = {'delivery':uuid_operation}
            response = requests.get(self.url+'/getSearchOperationPoints',data=json.dumps(payload),headers=headers)
            return response.text 
        
        except Exception as e:
             print(e)
             return "{}"
        
        
            
    def getOperationsActive(self,jwt,data):
        try:
            headers["content-type"]="application/json; charset=utf-8"
            headers["token-acess"]=jwt
            payload = {'data':data}
            response = requests.get(self.url+'/getOperationsActive',data=json.dumps(payload),headers=headers)
            return response.text
        
        except Exception as e:
             print(e)
             return json.loads("{}")
         
            
            
        
        




        
        
        
        