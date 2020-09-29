#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Fri Jul 17 12:01:06 2020

@author: edi
"""

 
import json
import base64
from datetime import date
import mysql.connector




class Operations(object):
    
    def __init__(self,localhost,user,password,port=3306):
            try:
                self.conn = mysql.connector.connect(
                          host=localhost,
                          user=user,
                          password=password,
                          port=port,
                          database="boot"
                        )
                
            except Exception as e:
                print("1")
                print(e)
                
                
            
            
    def addOperations(self,operacao):
         try:
             
             if self.checkoutIsOperationToBase({"delivery":operacao["delivery_id"]}):
                 cur = self.conn.cursor()
                 sql="INSERT INTO operations(delivery_id, status, metadata, dt_processing,delivery_raw)  VALUES (%s,%s,%s,%s,%s)"
                 val=(operacao["delivery_id"],operacao["status"],operacao["metadata"],operacao["dt_processing"],operacao["delivery_raw"])
                 cur.execute(sql,val)
                 self.conn.commit()
                 cur.close()
                 return True
             else:
                 return False
        
             
         except Exception as e:
             print("2")
             print(e)
    
    
    
    def uploadPhotosOfTheOperation(self,uuid,photos):
        try:
            photo_is_exixts=self.checkoutIsOperationPhotosToBase(uuid)
            
            if(photo_is_exixts > 0):
                return False
           
            cur = self.conn.cursor()
            metadata=base64.b64encode(bytes(json.dumps(photos),'utf-8'))
            cur.execute('INSERT INTO operations_photos (fk_delivery, metadata)  VALUES (%s,%s)',(uuid,metadata))
            self.conn.commit()
            cur.close()
              
                
        except Exception as e:
            print("3")
            print(e)
        
    
    

    def checkoutIsOperationPhotosToBase(self,uuid):
        try:
            
             
            cur = self.conn.cursor()
            cur.execute("SELECT count(*) as qt FROM operations_photos where fk_delivery ='"+uuid+"'")
            (number_of_rows,)=cur.fetchone()
            cur.close()
            return number_of_rows
            
        except Exception as e:
            print("4")
            print(e)
            return False    
     
    def updateOperations(self,uuid):
        try:
            data_atual = date.today()
            data_em_texto = data_atual.strftime("%d/%m/%Y")
            cur =self.conn.cursor()
            cur.execute("update operations set status='P' , dt_processed='"+data_em_texto+"' where delivery_id ='"+uuid+"'")
            number_of_rows=cur.rowcount
            self.conn.commit()
            cur.close()
            return number_of_rows
            
        except Exception as e:
            print("5")
            print(e)
            return False   



           
        
    def addPoitsOfTheOperation(self,uuid,poits):
        try:
            poits_is_exixts=self.checkoutIsOperationPhoitsToBase(uuid)
            if(poits_is_exixts > 0):
                return False
           
             
            cur = self.conn.cursor()
            metadata=base64.b64encode(bytes(json.dumps(poits),'utf-8'))
            cur.execute('INSERT INTO operations_poits (fk_delivery, metadata)  VALUES (%s,%s)',(uuid,metadata))
            self.conn.commit()
            cur.close()
              
                
        except Exception as e:
            print("6")
            print(e)
        

       
        
        
    def checkoutIsOperationPhoitsToBase(self,uuid):
        try:
            
            conn =self.conn
            cur = conn.cursor()
            cur.execute("SELECT count(*) as qt FROM operations_poits where fk_delivery ='"+uuid+"'")
            (number_of_rows,)=cur.fetchone()
            cur.close()
            return number_of_rows
            
        except Exception as e:
            print("7")
            print(e)
            return False    
     
        
        
        
        
    
    def checkoutIsOperationToBase(self,operations):
        try:
            
          
            cur = self.conn.cursor()
            cur.execute("SELECT count(*) as qt FROM operations where delivery_id ='"+operations["delivery"]+"'")
            (number_of_rows,)=cur.fetchone()
            cur.close()
            if(number_of_rows > 0):
                return False
            else:
                return True
            
        except Exception as e:
            print("8")
            print(e)
            return False
        
        
        
    def getOperationsNotStaticFile(self):
        operations=[]
        try:
            
            conn =self.conn
            cur = conn.cursor()
            cur.execute("SELECT * FROM operations where status ='N'")
            for row in cur:
                operations.append(row)
                
            cur.close()


        except Exception as e:
             print("9")
             pass
           
        return operations
    
    
    def getOperationsNotStaticFilePoits(self,delivery_id):
        operations=[]
        try:
            
            conn =self.conn
            cur = conn.cursor()
            cur.execute("SELECT * FROM operations_poits where fk_delivery ='"+delivery_id+"'")
            for row in cur:
                operations.append(row)

        except Exception as e:
             print("10")
             pass
           
        return operations
    
    
    
    
    
    def resetOperations(self,uuid):
            try:
                cur =self.conn.cursor()
                cur.execute("delete from operations  where delivery_id ='"+uuid+"'")
                #number_of_rows=cur.rowcount
                self.conn.commit()
                cur.execute("delete from operations_photos  where fk_delivery ='"+uuid+"'")
                #number_of_rows=cur.rowcount
                self.conn.commit()
               
                cur.execute("delete from operations_poits  where fk_delivery ='"+uuid+"'")
                #number_of_rows=cur.rowcount
                self.conn.commit()
                
                cur.close()
                return True
                
            except Exception as e:
                print("5")
                print(e)
                return False           
            
            
            
            
            
        
        