import csv
import codecs
import re
import glob
paths = glob.glob("lfw/*/*.jpg")
f = codecs.open('imagePaths.csv', mode='w', encoding="utf-8", errors="ignore")
for path in paths:
    f.write(path+'\n')
f.close()
    
