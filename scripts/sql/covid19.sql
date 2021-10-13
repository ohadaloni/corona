CREATE TABLE covid19 (
  id int NOT NULL AUTO_INCREMENT,
  date date,
  country varchar(255),
  cases int,
  deaths int,
  recovered int,
  tests int,
  vaccinated bigint,
  PRIMARY KEY (id),
  UNIQUE KEY date (date,country),
  KEY country (country,date)
)
