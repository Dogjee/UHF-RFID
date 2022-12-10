import sys
from time import sleep
import pymongo
import json
class rfid:
    def __init__(self,ms,x,y,idsach) :
        self.ms = ms
        self.x = x
        self.y = y
        self.idsach = idsach
    def inRFID(self):
        return "ms: {}, x: {}, y: {}, idsach: {}".format(self.ms,self.x,self.y,self.idsach)
    def getIdsach(self):
        return self.idsach
    def getMs(self):
        return self.ms

myclient = pymongo.MongoClient("mongodb://localhost:27017/")
mydb = myclient["mohinh"]
dataTH = mydb["join"]
rfidCol = mydb['rfid']
colSach = mydb['sach']
result = myclient['mohinh']['rfid'].aggregate([
    {
        '$lookup': {
            'from': 'datarfid', 
            'localField': 'ms', 
            'foreignField': 'ms', 
            'as': 'joinedResult'
        }
    }
])
def getData():
    result = myclient['mohinh']['rfid'].aggregate([
    {
        '$lookup': {
            'from': 'datarfid', 
            'localField': 'ms', 
            'foreignField': 'ms', 
            'as': 'joinedResult'
        }
    }
])
    dataTH.delete_many({})
    list1 = []
    listtemp = []

    for i in result:
    # print(i)
    # print(i['joinedResult'])
    # a = json.loads(i['joinedResult'])
    # list1.append[a]
        listtemp = []
        listtemp.append(i['ms'])
        listtemp.append(i['xrfid'])
        listtemp.append(i['yrfid'])

        for j in i['joinedResult'] :
            # print(j)
            listtemp.append(j['idsach'])
        list1.append(listtemp)
    
    # print(list1)

    data = []
    for i in  list1:
        for j in range (len(i)-3):
            x = { "ms": i[0], "xrfid": i[1], "yrfid" : i[2], "idsach" : i[j+3]}
            data.append(x)
        
    # print(data)
    dataTH.insert_many(data)

    # =========================
    list = []
    for x in dataTH.find({},{'_id':0}):
        list.append(x)
    y = json.dumps(list)
    z = json.loads(y)

    listRFID = []
    for i in z:
        # print(i)
        listRFID.append(rfid(i['ms'],i['xrfid'],i['yrfid'],i['idsach']))

    # tien hanh gom nhom nhung rfid co cung idsach:
    
    listGroup = []
    for i in range (len(listRFID)):
        # i.inRFID()
        # print(i.getIdsach())
        temp = [listRFID[i].getIdsach()]
        temp.append(listRFID[i].getMs())
        for j in range (i+1,len(listRFID)):
            if (listRFID[j].getIdsach() == listRFID[i].getIdsach()):
                # listGroup.append([listRFID[i].getMs(),listRFID[j].getMs()])
                temp.append(listRFID[j].getMs())
        listGroup.append(temp)

    # for i in range(len(listGroup)):
    #     for i in listGroup:
    #         if (len(i) ==3):
    #             listGroup.remove(i)

    # for d in range (len(listGroup)):
    # for i in listGroup:
    #     print(i)
    print("=========")
    listmoi = []
    for i in listGroup:
        item = i
        # print(item[0])
        has = 0
        for j in listmoi:
            if (item[0] == j[0]):
                has = 1
        if (has == 0):
            listmoi.append(i)

    for i in listmoi:
        print(i)
            
            
    # print("-----------")
    # for i in listGroup:
    #     print(i)
    # return listGroup
    return listmoi

# # [2, 1, 2, 4]
# # [4, 2, 4, 5]
# # [6, 2, 3, 5]
# # [5, 3, 5, 6, 9]
# # [5, 5, 6, 9]




# TINH TOAN DA XONG

def trackPhone(x1,y1,r1,x2,y2,r2,x3,y3,r3):
    listkq = []
    A = 2*x2 - 2*x1
    B = 2*y2 - 2*y1
    C = r1**2 - r2**2 - x1**2 + x2**2 - y1**2 + y2**2
    D = 2*x3 - 2*x2
    E = 2*y3 - 2*y2
    F = r2**2 - r3**2 - x2**2 + x3**2 - y2**2 + y3**2
    try:
        x = (C*E - F*B) / (E*A - B*D)
        y = (C*D - A*F) / (B*D - A*E)
        listkq.append(x)
        listkq.append(y)
        return listkq
    except ZeroDivisionError:
        listkq.append(-1)
        return listkq


def tinh(doge):
    x1 = 0
    y1 = 0
    x2 = 0
    y2 = 0
    x3 = 0
    y3 = 0
    for i in doge:
        sorfid = len(i) -1 
        if len(i) >3:
            idsach = i[0]
            ms1 = i[1]
            ms2 = i[2]
            ms3 = i[3]
            query = {'ms' : ms1}
            for a in rfidCol.find(query, {'_id' : 0}):
                x1 = a['xrfid']
                y1 = a['yrfid']
            query2 = {'ms' : ms2}
            for a in rfidCol.find(query2, {'_id' : 0}):
                x2 = a['xrfid']
                y2 = a['yrfid']
            query3 = {'ms' : ms3}
            for a in rfidCol.find(query3, {'_id' : 0}):
                x3 = a['xrfid']
                y3 = a['yrfid']

            listkq = trackPhone(x1,y1,1,x2,y2,1,x3,y3,1)
            if (listkq[0]!= -1):
                listkq.append(idsach)
                # print(listkq)
                # queryUpdate = {}
                queryUpdate = {"mass": listkq[2]}
                newvalues = { "$set": { "toadox": round(listkq[0]), "toadoy" :  round(listkq[1]) ,"sorfid" : sorfid } }
                colSach.update_one(queryUpdate, newvalues)
        elif(len(i) ==3 ):
            idsach = i[0]
            ms1 = i[1]
            ms2 = i[2]
            query = {'ms' : ms1}
            for a in rfidCol.find(query, {'_id' : 0}):
                x1 = a['xrfid']
                y1 = a['yrfid']
            query2 = {'ms' : ms2}
            for a in rfidCol.find(query2, {'_id' : 0}):
                x2 = a['xrfid']
                y2 = a['yrfid']
            queryUpdate = {"mass": idsach}
            newvalues = { "$set": { "toadox": round((x1+x2)/2), "toadoy" :  round((y1+y2)/2) ,"sorfid" : sorfid } }
            colSach.update_one(queryUpdate, newvalues)
        else:
            idsach = i[0]
            idrfid = i[1]
            # newvalues = { "$set": { "toadox": round(listkq[0]), "toadoy" :  round(listkq[1])} }
            query = {'ms' : idrfid}
            for a in rfidCol.find(query, {'_id' : 0}):
                x1 = a['xrfid']
                y1 = a['yrfid']
            queryUpdate = {"mass": idsach}
            newvalues = { "$set": { "toadox": x1, "toadoy" :  y1 , "sorfid" : sorfid} }
            colSach.update_one(queryUpdate, newvalues)




while True:
    try:
        listGroup = getData()
        tinh(listGroup)
        print('Update')
        sleep(1)
    except KeyboardInterrupt:
        print('Bye!')
        sys.exit(0)
# getData()