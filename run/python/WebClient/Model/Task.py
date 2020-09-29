#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Mon Jul 27 08:47:13 2020

@author: edi
"""
 
import mysql.connector
class Task(object):
        
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
                print(e)
            
       
        
            
        def setTheStockQueue(self,action,rawData):
            try:
                
                cur=self.conn.cursor()
                sql = "INSERT INTO task (activity, metadata) values(%s,%s)"
                val = (action, rawData)
                cur.execute(sql,val)
                self.conn.commit()
                number_of_rows=cur.rowcount
                cur.close()
                return number_of_rows
            
              
            except Exception as e:
                print(e)
                return False
            
            
        def pullFromTheStockQueue(self):
            actions=[]
            try:
                cur=self.conn.cursor()
                sql="SELECT ObjId,activity,metadata  FROM task"
                cur.execute(sql)
                results=cur.fetchall()
                for action in results:
                    actions.append({
                            "uuid":action[0],
                            "action":action[1],
                            "metadata":action[2]
                            
                            })
                cur.close()
            except Exception as e:
                print(e)
                
            return actions
        
        
        def deleteFromTheStockQueue(self,uuid):
            try:
                cur=self.conn.cursor()
                sql="delete from task where ObjId=%s"
                val=(uuid,)
                cur.execute(sql,val)
                self.conn.commit()
                number_of_rows=cur.rowcount
                cur.close()
                return number_of_rows
        
            except Exception as e:
                print(e)
                return False
    