#!/usr/bin/env python3
#-*-coding:utf-8-*-

import MySQLdb
import feedparser
import time
import datetime

cpt = 0
ssrequete = ""
tabtitle = []
# table des flux rss
tabrss = ['http://www.ash.tm.fr/rss.xml', 'http://www.tsa-quotidien.fr/rss-all',  'http://www.liens-socio.org/spip.php?page=backend&id_rubrique=21', 'http://calenda.org/feed.php?cat=209' , 'http://calenda.org/feed.php?cat=266', 'http://www2.assemblee-nationale.fr/feeds/detail/documents-parlementaires', 'http://www2.assemblee-nationale.fr/feeds/detail/ID_420120/(type)/instance','http://www.justice.gouv.fr/rss/actualites.xml','http://www.horizon2020.gouv.fr/rid4190/societes-inclusives.rss', 'http://www.psppaca.fr/spip.php?page=backend','http://social-sante.gouv.fr/spip.php?page=backend','http://www.espt.asso.fr/component/ninjarsssyndicator/?feed_id=1&format=raw','https://www.insee.fr/fr/flux/2','https://www.insee.fr/fr/flux/3','https://www.insee.fr/fr/flux/4','https://www.insee.fr/fr/flux/5','https://www.insee.fr/fr/flux/6']

# Connection a la base
myDB = MySQLdb.connect(host="192.168.1.34",port=3306,user="Vvinyl",passwd="Cadenet-84",db="ERMSS",use_unicode=True,charset="utf8")
cHandler = myDB.cursor()

# Calcul temps execution script
tmps1=time.clock()
date = datetime.datetime.now()

for lien in tabrss:
    # On parse le flux rss
    d = feedparser.parse(lien)
    # on parcours les résultats
    for flux in d.entries:
	    url = flux.link
	    title = flux.title
	    cHandler.execute("SELECT COUNT(*) FROM ERMSS.rss where url = '" + url + "';")
	    controlrss = cHandler.fetchall()
	    for items in controlrss:
		    if (items[0]<1):
			    cHandler.execute("SELECT COUNT(*) FROM ERMSS.depot_maj where url = '" + url + "';")
			    controldepot = cHandler.fetchall()
			    for itemsx in controldepot:
				    if (itemsx[0]<1)and(title not in tabtitle):
					    cpt = (cpt + 1)
					    ssrequete += "('rss', '" + title.replace("'", "\\'") + "', '" + url + "', '0'), "
					    tabtitle.append(title)
requete = "INSERT INTO `ERMSS`.`depot_maj` (`origine`, `titre`, `url`, `statut`) VALUES "
requete = requete + ssrequete
req = requete[0:-2]
if (cpt>1):
    cHandler.execute(req)

# Fin Calcul temps execution script et mise en log
tmps2=time.clock()
duree = (tmps2-tmps1)
req_histo = "INSERT INTO historique_cron (`date_cron`, `origin_cron`, `duree_cron`,`nb_cron`) VALUES (NOW(), 'rss', '" + str(round(duree,2)) + "','" + str(cpt) + "')"
cHandler.execute(req_histo)
cHandler.close()
