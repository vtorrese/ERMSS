#!/usr/bin/env python3
#-*-coding:utf-8-*-

import os
import csv
import requests
from bs4 import BeautifulSoup
import string

items = "exclusion"

requete = requests.get("https://www.google.fr/search?q=" + items + "&hl=fr&tbm=bks&source=lnt&tbs=sbd:1&sa=X&ved=0ahUKEwiw6PDb9O_cAhWHxYUKHWQCDMUQpwUIIA&biw=1440&bih=763&dpr=1")
page = requete.content
soup = BeautifulSoup(page,"html.parser")

taburl = []

for result in soup.select("div[class=g]"):
    titre = result.h3.get_text()
    url = result.a['href']
    if (url[:45] not in taburl):
	    taburl.append(url[:45])

print(taburl)

adresse = "https://books.google.fr/books?id=i7B_swEACAAJ&dq=psychiatrie&hl=fr&sa=X&ved=0ahUKEwjFoJ3joPHcAhUKyRoKHRh4BEAQ6AEITDAJ"


    
