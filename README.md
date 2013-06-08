epauvindex
==========

set of tools for scraping and interfacing with EPA UV Index data


#### demo

Working example can be seen here: [Daily EPA UV Index Heat Map] (http://mycodespace.net/projects/epauvindex/)


#### description

There are some bugs with the heatmap javascript library I used ... or how I am using it (one of those ... :p).  If it doesn't display, zoom in or out again and it should show up.


#### example:

![Example Image](http://i.imgur.com/XpzdwIB.jpg)


#### notes:

The scraper runs every night at 4am EST and takes about 4 hours to run.  Data will then be available after 8am EST each day for that specific day.  I hope to setup the script to upload the SQL each day to the git repo so there is a easy-to-get-to bulk download.

The scrapper pulls in data from the EPA for a few short of 40,000 zipcodes across the entire US.  It then attaches latitude and longitude data to each hourly data point for that zipcode.

If you would like additional API's added, please put them in the [issues] (https://github.com/thequbit/epauvindex/issues).  Thanks, and enjoy!
