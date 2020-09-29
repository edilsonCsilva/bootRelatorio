#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Thu Jul 16 15:27:22 2020

@author: edi
"""

 
import sqlite3
class Base(object):
    
    def __init__(self):
       conn = sqlite3.connect('boot.db')
       cur = conn.cursor()
       sql='CREATE TABLE IF NOT EXISTS settings( ObjId INTEGER PRIMARY KEY AUTOINCREMENT,   descricao TEXT  , metadados TEXT);'
       cur.execute(sql)
       sql='CREATE TABLE IF NOT EXISTS operations( ObjId INTEGER PRIMARY KEY AUTOINCREMENT,delivery_id TEXT NOT NULL,dt_processed TEXT,status TEXT NOT NULL,dt_processing TEXT NOT NULL, metadata TEXT);'
       cur.execute(sql)
       sql='CREATE TABLE IF NOT EXISTS operations_photos( ObjId INTEGER PRIMARY KEY AUTOINCREMENT,fk_delivery  TEXT NOT NULL, metadata TEXT);'
       cur.execute(sql)
       
       sql='CREATE TABLE IF NOT EXISTS operations_poits( ObjId INTEGER PRIMARY KEY AUTOINCREMENT,fk_delivery  TEXT NOT NULL, metadata TEXT);'
       cur.execute(sql)
       
       
       conn.close()
       
        