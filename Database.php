
-- -----------------------------------------------------
-- Table `mydb`.`ACCOUNT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ACCOUNT` (
  `AccountID` INT NOT NULL,
  `Username` VARCHAR(45) NOT NULL,
  `Password` VARCHAR(20) NOT NULL,
  `Email` VARCHAR(45) NOT NULL,
  `FirstName` VARCHAR(20) NOT NULL,
  `LastName` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`AccountID`));



-- -----------------------------------------------------
-- Table `mydb`.`NEWSLETTER`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NEWSLETTER` (
  `NewsletterID` INT NOT NULL,
  `Account` INT NOT NULL,
  `NewsletterName` VARCHAR(45) NOT NULL,
  `NewsletterDescription` VARCHAR(200) NOT NULL,
  `ACCOUNT_AccountID` INT NOT NULL,
  PRIMARY KEY (`NewsletterID`),
    FOREIGN KEY (`ACCOUNT_AccountID`)
    REFERENCES `ACCOUNT` (`AccountID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `mydb`.`USER ROLE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `USER ROLE` (
  `RoleID` INT NOT NULL,
  `RoleName` VARCHAR(45) NOT NULL,
  `RoleDescription` VARCHAR(250) NOT NULL,
  `ACCOUNT_AccountID` INT NOT NULL,
  PRIMARY KEY (`RoleID`),
    FOREIGN KEY (`ACCOUNT_AccountID`)
    REFERENCES `ACCOUNT` (`AccountID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `mydb`.`LOCATION`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `LOCATION` (
  `LocationID` INT NOT NULL,
  `LocationName` VARCHAR(45) NOT NULL,
  `LocationAddress` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`LocationID`));


-- -----------------------------------------------------
-- Table `mydb`.`EVENT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `EVENT` (
  `EventID` VARCHAR(45) NOT NULL,
  `Location` VARCHAR(45) NULL,
  `EventName` VARCHAR(45) NOT NULL,
  `EventDate` DATE NOT NULL,
  `EventDescription` VARCHAR(45) NULL,
  `LOCATION_LocationID` INT NOT NULL,
  `ACCOUNT_AccountID` INT NOT NULL,
  PRIMARY KEY (`EventID`),
    FOREIGN KEY (`LOCATION_LocationID`)
    REFERENCES `LOCATION` (`LocationID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    FOREIGN KEY (`ACCOUNT_AccountID`)
    REFERENCES `ACCOUNT` (`AccountID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `mydb`.`POST`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `POST` (
  `PostID` INT NOT NULL,
  `Post Title` VARCHAR(45) NOT NULL,
  `Post Content` VARCHAR(45) NOT NULL,
  `Date Posted` DATE NOT NULL,
  `ACCOUNT_AccountID` INT NOT NULL,
  PRIMARY KEY (`PostID`),
    FOREIGN KEY (`ACCOUNT_AccountID`)
    REFERENCES `ACCOUNT` (`AccountID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `mydb`.`PREFERENCE FORM`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PREFERENCE FORM` (
  `FormID` INT NOT NULL,
  `Account` VARCHAR(45) NOT NULL,
  `FormName` VARCHAR(45) NOT NULL,
  `Form Description` VARCHAR(45) NOT NULL,
  `ACCOUNT_AccountID` INT NOT NULL,
  PRIMARY KEY (`FormID`),
    FOREIGN KEY (`ACCOUNT_AccountID`)
    REFERENCES `ACCOUNT` (`AccountID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `mydb`.`SOCIAL MEDIA`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `SOCIAL MEDIA` (
  `Social Media ID` INT NOT NULL,
  `Account` VARCHAR(45) NOT NULL,
  `SocialMediaName` VARCHAR(45) NOT NULL,
  `SocialMediaURL` VARCHAR(45) NOT NULL,
  `ACCOUNT_AccountID` INT NOT NULL,
  PRIMARY KEY (`Social Media ID`, `ACCOUNT_AccountID`),
    FOREIGN KEY (`ACCOUNT_AccountID`)
    REFERENCES `ACCOUNT` (`AccountID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `mydb`.`NETWORK`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NETWORK` (
  `FrienderID` INT NOT NULL,
  `FriendeeID` INT NOT NULL,
  `NetworkName` VARCHAR(45) NOT NULL,
  `NetworkDescription` VARCHAR(45) NOT NULL,
  `ACCOUNT_AccountID` INT NOT NULL,
  PRIMARY KEY (`FrienderID`, `FriendeeID`, `ACCOUNT_AccountID`),
    FOREIGN KEY (`ACCOUNT_AccountID`)
    REFERENCES `ACCOUNT` (`AccountID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table `mydb`.`MESSAGE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `MESSAGE` (
  `FrienderID` INT NOT NULL,
  `Friendee` INT NOT NULL,
  `Message DATE/TIME` DATE NOT NULL,
  `Message Sender` VARCHAR(45) NULL,
  `Message Reciever` VARCHAR(45) NULL,
  `ACCOUNT_AccountID` INT NOT NULL,
  PRIMARY KEY (`FrienderID`, `Friendee`, `Message DATE/TIME`),
    FOREIGN KEY (`ACCOUNT_AccountID`)
    REFERENCES `ACCOUNT` (`AccountID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
