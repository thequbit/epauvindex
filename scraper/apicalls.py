import MySQLdb as mdb
import _mysql as mysql
import re

class apicalls:

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

    def add(self,apicalldt,iphash):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("INSERT INTO apicalls(apicalldt,iphash) VALUES(%s,%s)",(self.__sanitize(apicalldt),self.__sanitize(iphash)))
            cur.close()
            newid = cur.lastrowid
        return newid

    def get(self,apicallid):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT * FROM apicalls WHERE apicallid = %s",(apicallid))
            row = cur.fetchone()
            cur.close()
        return row

    def getall(self):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT * FROM apicalls")
            rows = cur.fetchall()
            cur.close()

        _apicalls = []
        for row in rows:
            _apicalls.append(row)

        return _apicalls

    def delete(self,apicallid):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("DELETE FROM apicalls WHERE apicallid = %s",(apicallid))
            cur.close()

    def update(self,apicallid,apicalldt,iphash):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("UPDATE apicalls SET apicalldt = %s,iphash = %s WHERE apicallid = %s",(self.__sanitize(apicalldt),self.__sanitize(iphash),self.__sanitize(apicallid)))
            cur.close()

##### Application Specific Functions #####
