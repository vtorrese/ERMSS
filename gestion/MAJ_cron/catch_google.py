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
    # Moteur de recherche google
    requete = requests.get("https://www.google.fr/search?q=" + items + "&hl=fr&tbm=bks&source=lnt&tbs=sbd:1&sa=X&ved=0ahUKEwiw6PDb9O_cAhWHxYUKHWQCDMUQpwUIIA&biw=1440&bih=763&dpr=1")
    page = requete.content
    soup = BeautifulSoup(page,"html.parser")
    taburl = []
    for result in soup.select("div[class=g]"):
	    titre = result.h3.get_text()
	    url = result.a['href']
	    cHandler.execute("SELECT COUNT(*) FROM depot_maj WHERE substring(url,1,45) = '" + url[:45] +"';")
	    results = cHandler.fetchall()
	    for items in results:
		    if (items[0]<1)and(url[:45] not in taburl):
			    # compteur de résultat
			    cpt = (cpt + 1)
			    ssrequete += "('google', '" + titre.replace("'", "\\'") + "', '" + url + "', '0'), "
			    taburl.append(url[:45])


requete = "INSERT INTO `ERMSS`.`depot_maj` (`origine`, `titre`, `url`, `statut`) VALUES "
requete = requete + ssrequete
req = requete[0:-2]
# print(req)
if (cpt>1):
    cHandler.execute(req)


# Fin Calcul temps execution script et mise en log
tmps2=time.clock()
duree = (tmps2-tmps1)
req_histo = "INSERT INTO historique_cron (`date_cron`, `origin_cron`, `duree_cron`,`nb_cron`) VALUES (NOW(), 'google', '" + str(round(duree,2)) + "','" + str(cpt) + "')"
cHandler.execute(req_histo)
cHandler.close()
# fichier = open("log_maj.txt", "a")
# fichier.write("\nMAJ 'google' effectuee le " + date.strftime('%d %b %Y %H:%M') + ", duree d'execution : " + str(round(duree,2)) + " sec, Nb de resultats " + str(cpt))
# fichier.close()




