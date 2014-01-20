SET NAMES 'utf8';

USE fet10009689;

DROP TABLE IF EXISTS national;
DROP TABLE IF EXISTS area;
DROP TABLE IF EXISTS region;
DROP TABLE IF EXISTS country;
DROP TABLE IF EXISTS crimestatistics;
DROP TABLE IF EXISTS geographicreference;

CREATE TABLE crimestatistics (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Homicide INT(11) DEFAULT NULL,
  ViolenceWithInjury INT(11) DEFAULT NULL,
  ViolenceWithoutInjury INT(11) NOT NULL,
  SexualOffenses INT(11) NOT NULL,
  Robbery INT(11) NOT NULL,
  TheftOffenses INT(11) NOT NULL,
  DomesticBurglary INT(11) NOT NULL,
  NonDomesticBurglary INT(11) NOT NULL,
  VehicleOffenses INT(11) NOT NULL,
  TheftFromPerson INT(11) NOT NULL,
  BicycleTheft INT(11) NOT NULL,
  Shoplifting INT(11) NOT NULL,
  MiscTheft INT(11) NOT NULL,
  CriminalDamageAndArson INT(11) NOT NULL,
  DrugOffenses INT(11) NOT NULL,
  PossesionOfWeapons INT(11) NOT NULL,
  PublicOrderOffenses INT(11) NOT NULL,
  MiscCrimes INT(11) NOT NULL,
  Fraud INT(11) NOT NULL,
  PRIMARY KEY (Id)
)
ENGINE = INNODB
AUTO_INCREMENT = 2
AVG_ROW_LENGTH = 16384
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

CREATE TABLE geographicreference (
  Id INT(11) NOT NULL AUTO_INCREMENT,
  Name VARCHAR(50) NOT NULL,
  PRIMARY KEY (Id)
)
ENGINE = INNODB
AUTO_INCREMENT = 5
AVG_ROW_LENGTH = 4096
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

CREATE TABLE country (
  GeographicReference_Id INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (GeographicReference_Id),
  UNIQUE INDEX UK_Country_GeographicReference (GeographicReference_Id),
  CONSTRAINT FK_Country_GeographicReference_Id FOREIGN KEY (GeographicReference_Id)
    REFERENCES geographicreference(Id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AVG_ROW_LENGTH = 16384
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

CREATE TABLE national (
  GeographicReference_Id INT(11) NOT NULL AUTO_INCREMENT,
  CrimeStatistics_Id INT(11) DEFAULT NULL,
  PRIMARY KEY (GeographicReference_Id),
  CONSTRAINT FK_National_CrimeStatistics_Id FOREIGN KEY (CrimeStatistics_Id)
    REFERENCES crimestatistics(Id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT FK_National_GeographicReference_Id FOREIGN KEY (GeographicReference_Id)
    REFERENCES geographicreference(Id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

CREATE TABLE region (
  GeographicReference_Id INT(11) NOT NULL DEFAULT 0,
  Country_Id INT(11) DEFAULT NULL,
  PRIMARY KEY (GeographicReference_Id),
  CONSTRAINT FK_Region_Country_GeographicReference_Id FOREIGN KEY (Country_Id)
    REFERENCES country(GeographicReference_Id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT FK_Region_GeographicReference_Id FOREIGN KEY (GeographicReference_Id)
    REFERENCES geographicreference(Id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AVG_ROW_LENGTH = 8192
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

CREATE TABLE area (
  GeographicReference_id INT(11) NOT NULL,
  CrimeStatistics_Id INT(11) DEFAULT NULL,
  Region_Id INT(11) DEFAULT NULL,
  PRIMARY KEY (GeographicReference_id),
  CONSTRAINT FK_Area_CrimeStatistics_Id FOREIGN KEY (CrimeStatistics_Id)
    REFERENCES crimestatistics(Id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT FK_Area_GeographicReference_Id FOREIGN KEY (GeographicReference_id)
    REFERENCES geographicreference(Id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT FK_area_region_GeographicReference_Id FOREIGN KEY (Region_Id)
    REFERENCES region(GeographicReference_Id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AVG_ROW_LENGTH = 16384
CHARACTER SET latin1
COLLATE latin1_swedish_ci;