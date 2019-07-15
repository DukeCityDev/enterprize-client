DROP TABLE IF EXISTS shift;
DROP TABLE IF EXISTS shiftPlan;
DROP TABLE IF EXISTS pod;
DROP TABLE IF EXISTS scon;

CREATE TABLE scon(
  sconId INT UNSIGNED AUTO_INCREMENT,
  netId VARCHAR(21) NOT NULL UNIQUE,
  firstName VARCHAR(45) NOT NULL ,
  middleInitial VARCHAR(1),
  lastName VARCHAR(45) NOT NULL,
  phoneNumber VARCHAR(17),
  email VARCHAR(75),
  startDate DATETIME,
  adminStatus BOOLEAN,

  PRIMARY KEY(sconId)
) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE pod(
  podId INT UNSIGNED AUTO_INCREMENT,
  podName VARCHAR(20) UNIQUE,
  PRIMARY KEY(podId)
)CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE shiftPlan(
  shiftPlanId INT UNSIGNED AUTO_INCREMENT,
  podId INT UNSIGNED NOT NULL,
  startDate DATETIME NOT NULL,
  endDate DATETIME NOT NULL,
  shiftPlanName VARCHAR(20),
  PRIMARY KEY(shiftPlanId),
  FOREIGN KEY(podId) REFERENCES pod(podId)
)CHARACTER SET utf8 COLLATE utf8_unicode_ci;


CREATE TABLE shift(
  shiftId INT UNSIGNED AUTO_INCREMENT,
  sconNetId VARCHAR(21),
  podId INT UNSIGNED NOT NULL,
  shiftPlanId INT UNSIGNED,
  startDate DATETIME NOT NULL,
  endDate DATETIME NOT NULL,
  available BOOLEAN,

  INDEX(sconNetId),
  INDEX(podId),
  INDEX(shiftPlanId),

  PRIMARY KEY(shiftId),
  FOREIGN KEY (sconNetId) REFERENCES scon(netId),
  FOREIGN KEY (podId) REFERENCES pod(podId),
  FOREIGN KEY (shiftPlanId) REFERENCES shiftPlan(shiftPlanId)

)CHARACTER SET utf8 COLLATE utf8_unicode_ci;

