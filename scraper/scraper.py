import sys
import time
import datetime

import urllib2
import urllib
import json

from zipcodes import zipcodes
from uvindices import uvindices
from nodatazips import nodatazips
from scraperuns import scraperuns

months = {'JAN': '01',
          'FEB': '02',
          'MAR': '03',
          'APR': '04',
          'MAY': '05',
          'JUN': '06',
          'JUL': '07',
          'AUG': '08',
          'SEP': '09',
          'OCT': '10',
          'NOV': '11',
          'DEC': '12'}

def getuvdata(zipcode):
    url = "http://iaspub.epa.gov/enviro/efservice/getEnvirofactsUVHOURLY/ZIP/{0}/json".format(zipcode)
    data = ""
    try:
        data = json.load(urllib2.urlopen(url,timeout=10))
    except:
        data = "ERROR"
    return data

def getzipcodes():
    zc = zipcodes()
    zcodes = zc.getall();
    return zcodes

def decodedt(dt):
    parts = dt.split(" ")
    dparts = parts[0].split("/")
    d = "{0}-{1}-{2}".format(dparts[2],months[dparts[0]],dparts[1])
    hour = int(parts[1])
    if parts[2] == "PM":
        hour = hour + 11
    t = "{0}:00:00".format(hour)
    return (d,t)

def saveuvindices(zcodes):
    uvi = uvindices()
    ndz = nodatazips()
    count = 0
    errors = 0
    for zcode in zcodes:
        zipcodeid,zipcode,_city,_state,lat,lng,timezone,dst = zcode
        today = datetime.datetime.now().date().isoformat()
        print "[INFO   ] Working on {0} ...".format(zipcode)
        if uvi.checkexists(zipcode,today) == False:
            hourly = getuvdata(zipcode)
            erronthis = 0
            while hourly == "ERROR" and erronthis < 6:
                print "[WARNING] HTTP error, retrying `{0}` (attempt: {1})".format(zipcode,erronthis)
                time.sleep(4)
                hourly = getuvdata(zipcode)
                erronthis += 1
            if erronthis >= 6:
                errors += 1
                if ndz.checkexists(zipcode) == False:
                    ndz.add(zipcode,zipcodeid)
            else:
                if len(hourly) == 0:
                    if ndz.checkexists(zipcode) == False:
                        ndz.add(zipcode,zipcodeid)            
                    print "[WARNING] No UV data for `{0}`".format(zipcode)
                else:
                    for hourdata in hourly:
                        d,t = decodedt(hourdata['DATE_TIME'])
                        uvi.add(zipcode,lat,lng,zipcodeid,d,t,hourdata['UV_VALUE'])
        else:
            print "[INFO   ] Skipping duplicate UV Index for `{0}`".format(zipcode)
        count += 1
    return count,errors

def split_list(alist, wanted_parts=1):
    length = len(alist)
    return [ alist[i*length // wanted_parts: (i+1)*length // wanted_parts] 
             for i in range(wanted_parts) ]

def main(argv):

    if len(argv) != 2:
        print "Usage:\n\n\tpython scraper.py <chuck>\n\n\t<chunk> - 1 or 2 represents which chuck of zipcodes to work on.\n\n"
        return
    else:
        chunk = int(argv[1])

    print "[SCRAPER] Starting Scrapper ..."

    startdt = datetime.datetime.now().isoformat()

    print "[SCRAPER] Getting zipcode from database ..."

    zcodes = getzipcodes()

    print "[SCRAPER] Successfully returned {0} zipcodes.".format(len(zcodes))

    if chunk == 1:
        workload = zcodes[0:len(zcodes)/2]
    elif chunk == 2:
        workload = zcodes[len(zcodes)/2:]
    else:
        print "Invalid Chunk number, please select 1 or 2.  Exiting."
        return

    print "[SCRAPER] Starting scraper.  Working on {0} zipcodes.".format(len(workload))

    count,httperrors = saveuvindices(workload)

    print "[SCRAPER] Scraper finished scraping {0} zipcodes successfully.".format(count)

    stopdt = datetime.datetime.now().isoformat()

    sr = scraperuns()
    todaydate = datetime.datetime.now().date().isoformat()
    sr.add(todaydate,startdt,stopdt,count,httperrors)

    print "[SCRAPER] Exiting Scrapper ..."

if __name__ == '__main__': sys.exit(main(sys.argv))
