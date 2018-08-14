import os
import csv
import requests
from bs4 import BeautifulSoup
import string

with open("cible.txt", "r") as fichier:
    cible = fichier.readline()

requete = requests.get("https://www.persee.fr/search?da=2018&q=" + cible + "&ta=article")
page = requete.content
soup = BeautifulSoup(page,"html.parser")


for result in soup.find_all("div", class_="doc-result"):
    titre = result.find("a").get_text()
    url = result.find("a").get('href')
    print(titre + '|' + url)