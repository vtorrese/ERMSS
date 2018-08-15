#!/usr/bin/env python3
#-*-coding:utf-8-*-

import os
import csv
import requests
from bs4 import BeautifulSoup
import string
import MySQLdb
import time
import datetime


# Calcul temps execution script
tmps1=time.clock()
date = datetime.datetime.now()
annee = str(date.year)
 
# Connection a la base
myDB = MySQLdb.connect(host="192.168.1.34",port=3306,user="Vvinyl",passwd="Cadenet-84",db="ERMSS",use_unicode=True,charset="utf8")
cHandler = myDB.cursor()

# Creation de la liste de themes
results = ['exclusion','discrimination','prison','protection sociale','emploi','handicap','logement','justice','travail social','psychiatrie']
ssrequete = ""
cpt = 0
for items in results:
    # Moteur de recherche persee
    requete = requests.get("https://www.persee.fr/search?da=" + annee + "&q=" + items)
    page = requete.content
    soup = BeautifulSoup(page,"html.parser")    

    for result in soup.find_all("div", class_="doc-result"):
	    titre = result.find("a").get_text()
	    url = result.find("a").get('href')
	    cHandler.execute("SELECT COUNT(*) FROM depot_maj WHERE url = '" + url +"';")
	    results = cHandler.fetchall()
	    for items in results:
		    if (items[0]<1):
			    # compteur de résultat
			    cpt = (cpt + 1)
			    ssrequete += "('persee', '" + titre + "', '" + url + "', false), "

requete = "INSERT INTO `ERMSS`.`depot_maj` (`origine`, `titre`, `url`, `statut`) VALUES "
requete = requete + ssrequete
req = requete[0:-2]
if (cpt>1):
    cHandler.execute(req)
cHandler.close()

# Fin Calcul temps execution script et mise en log
tmps2=time.clock()
duree = (tmps2-tmps1)
fichier = open("log_maj.txt", "a")
fichier.write("\nMAJ 'persee' effectuee le " + date.strftime('%d %b %Y %H:%M') + ", duree d'execution : " + str(round(duree,2)) + " sec, Nb de resultats " + str(cpt))
fichier.close()


