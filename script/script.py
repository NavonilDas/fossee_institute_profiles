import pymysql
import re

# Required Variables
db_name = 'fossee_new' # Default database
table_name = 'clg_names'

file = open("del.sql",'w') #open the sql file
file.write('use '+db_name)
file.write('\n')
#words to be removed
nre = ['.',' engineering',' group',' college',
' technology',' institution','dr',
' university',' institute',' eng',' management',' national',' chemical',
' science',' of',' tech',' and',' &']

tospace = [',']

conn = pymysql.connect(
    host="localhost",user="root",password="",db=db_name
)
a = conn.cursor()
query = "SELECT * FROM clg_names ORDER BY CHAR_LENGTH(name)"
a.execute(query)
clgdic = []
tmp = {}
datas = a.fetchall() # fetch all the rows
selected = [] #temp dictonary to store Alerady deleted values

for data in datas:
    tmp = {}
    x = data[0].lower()
    for i in range(0,18):
        x = x.replace(str(nre[i]),'')
    tmp['name'] = x.replace(',',' , ').replace('-',' ').split()
    tmp['city'] = data[1]
    tmp['state'] = data[2]
    tmp['orig'] = data[0]
    if(len(data[0].replace(" ","")) > 5):
        clgdic.append(tmp)

l = len(clgdic)
for i in range(0,l-1):
    for j in range(i+1,l):
        match = 0
        for val in clgdic[i]['name']:
            if((val.replace(" ","") in " ".join(clgdic[j]['name'])) and val != ','): match += 1
        if(match >= 1):
            if(len(clgdic[j]['orig']) > len(clgdic[i]['orig'])):
                if(clgdic[i]['orig'] not in selected):
                    que = 'DELETE FROM '+table_name+' WHERE name = \"'+clgdic[i]['orig']+'\";'
                    selected.append(clgdic[i]['orig'])
                    file.write(que)
                    file.write('\n')
            else:
                if(clgdic[j]['orig'] not in selected):
                    que = 'DELETE FROM '+table_name+' WHERE name = \"'+clgdic[j]['orig']+'\";'
                    selected.append(clgdic[j]['orig'])
                    file.write(que)
                    file.write('\n')
print('filesaved')
conn.close()