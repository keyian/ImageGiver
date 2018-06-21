import csv
from bs4 import BeautifulSoup
import codecs
import re

#open file
writ = open("dictionary.csv", "w")
path= "OPTED/v003/wb1913_"
letterFiles = ["a.html", "b.html", "c.html", "d.html", "e.html", "f.html", "g.html", "h.html", "i.html", "j.html", "k.html", "l.html", "m.html", "n.html", "o.html", "p.html", "q.html", "r.html", "s.html", "t.html", "u.html", "v.html", "w.html", "x.html", "y.html", "z.html"]
for let in letterFiles:
    fullPath = path+let
    f = codecs.open((fullPath), mode="r", encoding="utf-8", errors="ignore")
    html_code = f.read()
    soup = BeautifulSoup(html_code, "html.parser")
    words = soup.find_all("p")
    for entry in words:
       word = ''.join((entry.b.contents))
       word = word.lower()
       pos = ''.join((entry.i.contents))
       pos = pos.replace(".", "")
       pos = pos.replace("&", "")
       writ.write(word+","+pos+","+"\n")
    print("ok")
    f.close()
writ.close()
