import time
import datetime

from uvindices import uvindices 

total = float(43191 * 21)

uvi = uvindices()

lastcount = float(-1)
lastcount2 = float(-1)
lastcount3 = float(-1)
count = float(0)

while(True):
    count = float(uvi.getcount())
    complete = count/total * 100
    rps = count - lastcount
    rps = rps / 60
    print "[{0}] {1}% Complete. Records Per Second: {2}".format(datetime.datetime.now(),complete,rps)
    lastcount3 = lastcount2;
    lastcount2 = lastcount
    lastcount = count
    time.sleep(60)

print datetime.datetime.now()
