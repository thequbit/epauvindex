import MySQLdb as mdb
import _mysql as mysql
import re

class uvindices:

    __settings = {}
    __con = False

    def __init__(self):
        configfile = "sqlcreds.txt"
        f = open(configfile)
        for line in f:
            # skip comment lines
            m = re.search('^\s*#', line)
            if m:
                continue

            # parse key=value lines
            m = re.search('^(\w+)\s*=\s*(\S.*)$', line)
            if m is None:
                continue

            self.__settings[m.group(1)] = m.group(2)
        f.close()

        # create connection
        self.__con = mdb.connect(host=self.__settings['host'], user=self.__settings['username'], passwd=self.__settings['password'], db=self.__settings['database'])

    def __sanitize(self,valuein):
        if type(valuein) == 'str':
            valueout = mysql.escape_string(valuein)
        else:
            valueout = valuein
        return valuein

    def add(self,zipcode,latitude,longitude,zipcodeid,uvindexdate,uvindextime,uvindex):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("INSERT INTO uvindices(zipcode,latitude,longitude,zipcodeid,uvindexdate,uvindextime,uvindex) VALUES(%s,%s,%s,%s,%s,%s,%s)",(self.__sanitize(zipcode),self.__sanitize(latitude),self.__sanitize(longitude),self.__sanitize(zipcodeid),self.__sanitize(uvindexdate),self.__sanitize(uvindextime),self.__sanitize(uvindex)))
            cur.close()
            newid = cur.lastrowid
        return newid

    def get(self,uvindexid):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT * FROM uvindices WHERE uvindexid = %s",(uvindexid))
            row = cur.fetchone()
            cur.close()
        return row

    def getall(self):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT * FROM uvindices")
            rows = cur.fetchall()
            cur.close()

        _uvindices = []
        for row in rows:
            _uvindices.append(row)

        return _uvindices

    def delete(self,uvindexid):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("DELETE FROM uvindices WHERE uvindexid = %s",(uvindexid))
            cur.close()

    def update(self,uvindexid,zipcode,latitude,longitude,zipcodeid,uvindexdate,uvindextime,uvindex):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("UPDATE uvindices SET zipcode = %s,latitude = %s,longitude = %s,zipcodeid = %s,uvindexdate = %s,uvindextime = %s,uvindex = %s WHERE uvindexid = %s",(self.__sanitize(zipcode),self.__sanitize(latitude),self.__sanitize(longitude),self.__sanitize(zipcodeid),self.__sanitize(uvindexdate),self.__sanitize(uvindextime),self.__sanitize(uvindex),self.__sanitize(uvindexid)))
            cur.close()

##### Application Specific Functions #####

    def getcount(self):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT count(*) as count FROM uvindices")
            row = cur.fetchone()
            cur.close()
        count, = row
        return count

    def checkexists(self,zipcode,uvindexdate):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT count(*) as count FROM uvindices where zipcode = %s and uvindexdate = %s",(zipcode,uvindexdate))
            row = cur.fetchone()
            cur.close()
        count, = row
        return bool(count)

