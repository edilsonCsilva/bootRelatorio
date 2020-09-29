#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Mon Jul 20 14:40:45 2020

@author: edi
"""

import base64

f="data to be encoded"

encoded = base64.b64encode(b'dsad')
print(encoded)
data = base64.b64decode(encoded)
print(data)


b = bytes(f, 'utf-8')
encoded = base64.b64encode(b)
print(encoded)
data = base64.b64decode(encoded)
print(data)

