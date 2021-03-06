import MySQLdb as mdb
import _mysql as mysql
import re

class zipcodes:

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

    def add(self,zipcode,city,state,latitude,longitude,timezone,dst):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("INSERT INTO zipcodes(zipcode,city,state,latitude,longitude,timezone,dst) VALUES(%s,%s,%s,%s,%s,%s,%s)",(self.__sanitize(zipcode),self.__sanitize(city),self.__sanitize(state),self.__sanitize(latitude),self.__sanitize(longitude),self.__sanitize(timezone),self.__sanitize(dst)))
            cur.close()
            newid = cur.lastrowid
        return newid

    def get(self,zipcodeid):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT * FROM zipcodes WHERE zipcodeid = %s",(zipcodeid))
            row = cur.fetchone()
            cur.close()
        return row

    def getall(self):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT * FROM zipcodes")
            rows = cur.fetchall()
            cur.close()

        _zipcodes = []
        for row in rows:
            _zipcodes.append(row)

        return _zipcodes

    def delete(self,zipcodeid):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("DELETE FROM zipcodes WHERE zipcodeid = %s",(zipcodeid))
            cur.close()

    def update(self,zipcodeid,zipcode,city,state,latitude,longitude,timezone,dst):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("UPDATE zipcodes SET zipcode = %s,city = %s,state = %s,latitude = %s,longitude = %s,timezone = %s,dst = %s WHERE zipcodeid = %s",(self.__sanitize(zipcode),self.__sanitize(city),self.__sanitize(state),self.__sanitize(latitude),self.__sanitize(longitude),self.__sanitize(timezone),self.__sanitize(dst),self.__sanitize(zipcodeid)))
            cur.close()

##### Application Specific Functions #####
