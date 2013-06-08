drop database epauvindex;
create database epauvindex;

grant usage on epauvindex.* to epauvuser identified by 'password123%%%';

grant all privileges on epauvindex.* to epauvuser;

use epauvindex;

create table zipcodes (
zipcodeid int not null auto_increment primary key,
zipcode varchar(8) not null,
city varchar(255) not null,
state varchar(128) not null,
latitude double not null,
longitude double not null,
timezone int not null,
dst bool not null
);

create index zipcodes_zipcodeid on zipcodes(zipcodeid);
create index zipcodes_zipcode on zipcodes(zipcode);
create index zipcodes_state on zipcodes(state);
create index zipcodes_lat on zipcodes(latitude);
create index zipcodes_lng on zipcodes(longitude);

create table nodatazips (
nodatazipid int not null auto_increment primary key,
zipcode varchar(8) not null,
zipcodeid int not null,
foreign key (zipcodeid) references zipcodes(zipcodeid)
);

create table uvindices (
uvindexid int not null auto_increment primary key,
zipcode varchar(8) not null,
latitude double not null,
longitude double not null,
zipcodeid int not null,
foreign key (zipcodeid) references zipcodes(zipcodeid), 
uvindexdate date not null,
uvindextime time not null,
uvindex int not null
);

create index uvindices_zipcode on uvindices(zipcode);
create index uvindices_lat on uvindices(latitude);
create index uvindices_lng on uvindices(longitude);
create index uvindices_uvindexdate on uvindices(uvindexdate);
create index uvindices_uvindextime on uvindices(uvindextime);
create index uvindices_uvindex on uvindices(uvindex);

create table apicalls(
apicallid int not null auto_increment primary key,
apicalldt datetime not null,
iphash varchar(255) not null
);

create table scraperuns(
scraperunid int not null auto_increment primary key,
uvdatadate date not null,
startdatetime datetime not null,
enddatetime datetime not null,
zipcount int not null,
httperrors int not null
);
