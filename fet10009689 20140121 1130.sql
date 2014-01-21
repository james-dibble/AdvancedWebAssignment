
SET NAMES 'utf8';

USE fet10009689;


DROP TABLE IF EXISTS crime_statistic_types;
CREATE TABLE crime_statistic_types (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(50) NOT NULL,
  Abbreviation VARCHAR(10) NOT NULL,
  PRIMARY KEY (Id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

DROP TABLE IF EXISTS geographic_references;
CREATE TABLE geographic_references (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(50) NOT NULL,
  PRIMARY KEY (Id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET latin1
COLLATE latin1_swedish_ci;


DROP TABLE IF EXISTS countrys;
CREATE TABLE countrys (
  GeographicReference_Id INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (GeographicReference_Id),
  CONSTRAINT FK_Country_geographic_reference_Id FOREIGN KEY (GeographicReference_Id)
    REFERENCES geographic_references(Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET latin1
COLLATE latin1_swedish_ci;


DROP TABLE IF EXISTS regions;
CREATE TABLE regions (
  GeographicReference_Id INT(11) NOT NULL AUTO_INCREMENT,
  Country_Id INT(11) NOT NULL,
  PRIMARY KEY (GeographicReference_Id),
  CONSTRAINT FK_region_country_GeographicReference_Id FOREIGN KEY (Country_Id)
    REFERENCES countrys(GeographicReference_Id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_Region_geographic_reference_Id FOREIGN KEY (GeographicReference_Id)
    REFERENCES geographic_references(Id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

DROP TABLE IF EXISTS areas;
CREATE TABLE areas (
  GeographicReference_Id INT(11) NOT NULL AUTO_INCREMENT,
  Region_Id INT(11) DEFAULT NULL,
  PRIMARY KEY (GeographicReference_Id),
  CONSTRAINT FK_Area_geographic_reference_Id FOREIGN KEY (GeographicReference_Id)
    REFERENCES geographic_references(Id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_area_region_GeographicReference_Id FOREIGN KEY (Region_Id)
    REFERENCES regions(GeographicReference_Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET latin1
COLLATE latin1_swedish_ci;


DROP TABLE IF EXISTS crime_statistics;
CREATE TABLE crime_statistics (
  Area_Id INT(11) NOT NULL,
  CrimeStatisticType_Id INT(11) NOT NULL,
  Value INT(11) NOT NULL,
  PRIMARY KEY (CrimeStatisticType_Id, Area_Id),
  CONSTRAINT FK_crime_statistics_area_GeographicReference_Id FOREIGN KEY (Area_Id)
    REFERENCES areas(GeographicReference_Id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT FK_crime_statistics_crime_statistic_type_Id FOREIGN KEY (CrimeStatisticType_Id)
    REFERENCES crime_statistic_types(Id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
CHARACTER SET latin1
COLLATE latin1_swedish_ci;


DROP TABLE IF EXISTS nationals;
CREATE TABLE nationals (
  Area_Id INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (Area_Id),
  CONSTRAINT FK_National_area_GeographicReference_Id FOREIGN KEY (Area_Id)
    REFERENCES areas(GeographicReference_Id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET latin1
COLLATE latin1_swedish_ci;
