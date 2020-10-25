DROP TABLE IF EXISTS covid19;
CREATE TABLE covid19 (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  country varchar(255) DEFAULT NULL,
  cases int(11) DEFAULT NULL,
  deaths int(11) DEFAULT NULL,
  recovered int(11) DEFAULT NULL,
  tests int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`,country),
  KEY country (country,`date`)
);
