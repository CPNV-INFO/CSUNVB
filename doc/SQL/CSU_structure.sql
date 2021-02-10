-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema csunvb_csu
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema csunvb_csu
-- -----------------------------------------------------
<<<<<<< HEAD
CREATE SCHEMA IF NOT EXISTS `csunvb_csu` DEFAULT CHARACTER SET utf8 ;
=======
DROP DATABASE IF EXISTS `csunvb_csu`;
CREATE SCHEMA `csunvb_csu` DEFAULT CHARACTER SET utf8 ;
>>>>>>> master
USE `csunvb_csu` ;

-- -----------------------------------------------------
-- Table `csunvb_csu`.`bases`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`bases` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
<<<<<<< HEAD
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`novas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`novas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `number` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `number_UNIQUE` (`number` ASC) VISIBLE)
ENGINE = InnoDB;
=======
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;
>>>>>>> master


-- -----------------------------------------------------
-- Table `csunvb_csu`.`drugs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`drugs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
<<<<<<< HEAD
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
ENGINE = InnoDB;
=======
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;
>>>>>>> master


-- -----------------------------------------------------
-- Table `csunvb_csu`.`batches`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`batches` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `number` VARCHAR(45) NOT NULL,
  `state` VARCHAR(45) NOT NULL DEFAULT 'new',
  `drug_id` INT NOT NULL,
  `base_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
<<<<<<< HEAD
  UNIQUE INDEX `number_UNIQUE` (`number` ASC) VISIBLE,
  INDEX `fk_batches_drugs_idx` (`drug_id` ASC) VISIBLE,
  INDEX `fk_batches_bases1_idx` (`base_id` ASC) VISIBLE,
=======
  UNIQUE INDEX `number_UNIQUE` (`number` ASC),
  INDEX `fk_batches_drugs_idx` (`drug_id` ASC),
  INDEX `fk_batches_bases1_idx` (`base_id` ASC),
>>>>>>> master
  CONSTRAINT `fk_batches_bases1`
    FOREIGN KEY (`base_id`)
    REFERENCES `csunvb_csu`.`bases` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_batches_drugs`
    FOREIGN KEY (`drug_id`)
    REFERENCES `csunvb_csu`.`drugs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
<<<<<<< HEAD
ENGINE = InnoDB;
=======
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(25) NOT NULL,
  `displayname` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `slug` (`slug` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;
>>>>>>> master


-- -----------------------------------------------------
-- Table `csunvb_csu`.`drugsheets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`drugsheets` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `week` INT NOT NULL,
<<<<<<< HEAD
  `state` VARCHAR(45) NOT NULL,
  `base_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `drugSHEETUNIQ` (`week` ASC, `base_id` ASC) VISIBLE,
  INDEX `fk_drugsheets_bases1_idx` (`base_id` ASC) VISIBLE,
=======
  `status_id` INT(11) NOT NULL,
  `base_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `drugSHEETUNIQ` (`week` ASC, `base_id` ASC),
  INDEX `fk_drugsheets_bases1_idx` (`base_id` ASC),
  INDEX `fk_drugsheets_status1` (`status_id` ASC),
>>>>>>> master
  CONSTRAINT `fk_drugsheets_bases1`
    FOREIGN KEY (`base_id`)
    REFERENCES `csunvb_csu`.`bases` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`drugsheet_use_batch`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`drugsheet_use_batch` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `drugsheet_id` INT NOT NULL,
  `batch_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unique_use` (`drugsheet_id` ASC, `batch_id` ASC),
  INDEX `fk_drugsheet_use_batch_drugsheets1_idx` (`drugsheet_id` ASC),
  INDEX `fk_drugsheet_use_batch_batches1_idx` (`batch_id` ASC),
  CONSTRAINT `fk_drugsheet_use_batch_batches1`
    FOREIGN KEY (`batch_id`)
    REFERENCES `csunvb_csu`.`batches` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_drugsheet_use_batch_drugsheets1`
    FOREIGN KEY (`drugsheet_id`)
    REFERENCES `csunvb_csu`.`drugsheets` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`novas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`novas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `number` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `number_UNIQUE` (`number` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`drugsheet_use_nova`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`drugsheet_use_nova` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `drugsheet_id` INT NOT NULL,
  `nova_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unique_use` (`drugsheet_id` ASC, `nova_id` ASC),
  INDEX `fk_drugsheet_use_nova_drugsheets1_idx` (`drugsheet_id` ASC),
  INDEX `fk_drugsheet_use_nova_novas1_idx` (`nova_id` ASC),
  CONSTRAINT `fk_drugsheet_use_nova_drugsheets1`
    FOREIGN KEY (`drugsheet_id`)
    REFERENCES `csunvb_csu`.`drugsheets` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_drugsheet_use_nova_novas1`
    FOREIGN KEY (`nova_id`)
    REFERENCES `csunvb_csu`.`novas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NOT NULL,
  `lastname` VARCHAR(45) NOT NULL,
  `initials` VARCHAR(45) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `admin` TINYINT NOT NULL,
  `firstconnect` TINYINT NOT NULL,
  `email` VARCHAR(254) NULL,
  `mobileNumber` VARCHAR(20) NULL,
  PRIMARY KEY (`id`),
<<<<<<< HEAD
  UNIQUE INDEX `initials_UNIQUE` (`initials` ASC) VISIBLE)
ENGINE = InnoDB;
=======
  UNIQUE INDEX `initials_UNIQUE` (`initials` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;
>>>>>>> master


-- -----------------------------------------------------
-- Table `csunvb_csu`.`drugsignatures`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`drugsignatures` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL,
  `day` INT NOT NULL,
  `drugsheet_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
<<<<<<< HEAD
  INDEX `fk_pharmachecks_batches1_idx` (`batch_id` ASC) VISIBLE,
  INDEX `fk_pharmachecks_users1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_pharmachecks_drugsheets1_idx` (`drugsheet_id` ASC) VISIBLE,
  CONSTRAINT `fk_pharmachecks_batches1`
    FOREIGN KEY (`batch_id`)
    REFERENCES `csunvb_csu`.`batches` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pharmachecks_drugsheets1`
=======
  INDEX `fk_drugsignatures_drugsheets1_idx` (`drugsheet_id` ASC),
  INDEX `fk_drugsignatures_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_drugsignatures_drugsheets1`
>>>>>>> master
    FOREIGN KEY (`drugsheet_id`)
    REFERENCES `csunvb_csu`.`drugsheets` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_drugsignatures_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`logs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`logs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `timestamp` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `user_id` INT(11) NOT NULL,
  `report_type` ENUM('SHIFT','TODO','DRUG') NOT NULL,
  `report_id` INT(11) NOT NULL COMMENT 'A foreign key without constraint, because it will point to different tables according to the report type',
  PRIMARY KEY (`id`),
  INDEX `fkmadeby_idx` (`user_id` ASC),
  CONSTRAINT `fkmadeby`
    FOREIGN KEY (`user_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'This table contains all log entries for all reports';


-- -----------------------------------------------------
-- Table `csunvb_csu`.`novachecks`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`novachecks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL,
  `start` INT NOT NULL,
  `end` INT NULL,
  `drug_id` INT NOT NULL,
  `nova_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `drugsheet_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
<<<<<<< HEAD
  INDEX `fk_novachecks_drugs1_idx` (`drug_id` ASC) VISIBLE,
  INDEX `fk_novachecks_novas1_idx` (`nova_id` ASC) VISIBLE,
  INDEX `fk_novachecks_users1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_novachecks_drugsheets1_idx` (`drugsheet_id` ASC) VISIBLE,
=======
  INDEX `fk_novachecks_drugs1_idx` (`drug_id` ASC),
  INDEX `fk_novachecks_novas1_idx` (`nova_id` ASC),
  INDEX `fk_novachecks_users1_idx` (`user_id` ASC),
  INDEX `fk_novachecks_drugsheets1_idx` (`drugsheet_id` ASC),
>>>>>>> master
  CONSTRAINT `fk_novachecks_drugs1`
    FOREIGN KEY (`drug_id`)
    REFERENCES `csunvb_csu`.`drugs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_novachecks_drugsheets1`
    FOREIGN KEY (`drugsheet_id`)
    REFERENCES `csunvb_csu`.`drugsheets` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_novachecks_novas1`
    FOREIGN KEY (`nova_id`)
    REFERENCES `csunvb_csu`.`novas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_novachecks_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`pharmachecks`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`pharmachecks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL,
  `start` INT NOT NULL,
  `end` INT NULL,
  `batch_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `drugsheet_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
<<<<<<< HEAD
  INDEX `fk_restocks_batches1_idx` (`batch_id` ASC) VISIBLE,
  INDEX `fk_restocks_novas1_idx` (`nova_id` ASC) VISIBLE,
  INDEX `fk_restocks_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_restocks_batches1`
=======
  INDEX `fk_pharmachecks_batches1_idx` (`batch_id` ASC),
  INDEX `fk_pharmachecks_users1_idx` (`user_id` ASC),
  INDEX `fk_pharmachecks_drugsheets1_idx` (`drugsheet_id` ASC),
  CONSTRAINT `fk_pharmachecks_batches1`
>>>>>>> master
    FOREIGN KEY (`batch_id`)
    REFERENCES `csunvb_csu`.`batches` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
<<<<<<< HEAD
  CONSTRAINT `fk_restocks_novas1`
    FOREIGN KEY (`nova_id`)
    REFERENCES `csunvb_csu`.`novas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restocks_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`drugsignatures`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`drugsignatures` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL,
  `day` INT NOT NULL,
  `drugsheet_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_drugsignatures_drugsheets1_idx` (`drugsheet_id` ASC) VISIBLE,
  INDEX `fk_drugsignatures_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_drugsignatures_drugsheets1`
=======
  CONSTRAINT `fk_pharmachecks_drugsheets1`
>>>>>>> master
    FOREIGN KEY (`drugsheet_id`)
    REFERENCES `csunvb_csu`.`drugsheets` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pharmachecks_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
<<<<<<< HEAD
-- Table `csunvb_csu`.`drugsheet_use_nova`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`drugsheet_use_nova` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `drugsheet_id` INT NOT NULL,
  `nova_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unique_use` (`drugsheet_id` ASC, `nova_id` ASC) VISIBLE,
  INDEX `fk_drugsheet_use_nova_drugsheets1_idx` (`drugsheet_id` ASC) VISIBLE,
  INDEX `fk_drugsheet_use_nova_novas1_idx` (`nova_id` ASC) VISIBLE,
  CONSTRAINT `fk_drugsheet_use_nova_drugsheets1`
    FOREIGN KEY (`drugsheet_id`)
    REFERENCES `csunvb_csu`.`drugsheets` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_drugsheet_use_nova_novas1`
    FOREIGN KEY (`nova_id`)
    REFERENCES `csunvb_csu`.`novas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`drugsheet_use_batch`
=======
-- Table `csunvb_csu`.`restocks`
>>>>>>> master
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`restocks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL,
  `quantity` INT NOT NULL,
  `batch_id` INT NOT NULL,
  `nova_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
<<<<<<< HEAD
  UNIQUE INDEX `unique_use` (`drugsheet_id` ASC, `batch_id` ASC) VISIBLE,
  INDEX `fk_drugsheet_use_batch_drugsheets1_idx` (`drugsheet_id` ASC) VISIBLE,
  INDEX `fk_drugsheet_use_batch_batches1_idx` (`batch_id` ASC) VISIBLE,
  CONSTRAINT `fk_drugsheet_use_batch_batches1`
=======
  INDEX `fk_restocks_batches1_idx` (`batch_id` ASC),
  INDEX `fk_restocks_novas1_idx` (`nova_id` ASC),
  INDEX `fk_restocks_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_restocks_batches1`
>>>>>>> master
    FOREIGN KEY (`batch_id`)
    REFERENCES `csunvb_csu`.`batches` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
<<<<<<< HEAD
  CONSTRAINT `fk_drugsheet_use_batch_drugsheets1`
    FOREIGN KEY (`drugsheet_id`)
    REFERENCES `csunvb_csu`.`drugsheets` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`todosheets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`todosheets` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `week` INT NOT NULL,
  `state` VARCHAR(45) NOT NULL,
  `base_id` INT NOT NULL,
  `template_name` VARCHAR(45) NULL DEFAULT NULL COMMENT 'The name under which the drugsheet may be identified as a templatre to be create new sheets. Copies will NOT carry that name',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `model_name_UNIQUE` (`template_name` ASC) VISIBLE,
  INDEX `fk_todosheets_bases1_idx` (`base_id` ASC) VISIBLE,
  CONSTRAINT `fk_todosheets_bases1`
    FOREIGN KEY (`base_id`)
    REFERENCES `csunvb_csu`.`bases` (`id`)
    ON DELETE NO ACTION
=======
  CONSTRAINT `fk_restocks_novas1`
    FOREIGN KEY (`nova_id`)
    REFERENCES `csunvb_csu`.`novas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restocks_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
    ON DELETE NO ACTION
>>>>>>> master
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`shiftsections`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`shiftsections` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
<<<<<<< HEAD
  UNIQUE INDEX `text_UNIQUE` (`description` ASC) VISIBLE)
ENGINE = InnoDB;
=======
  UNIQUE INDEX `title_UNIQUE` (`title` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;
>>>>>>> master


-- -----------------------------------------------------
-- Table `csunvb_csu`.`shiftactions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`shiftactions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `text` VARCHAR(45) NOT NULL,
  `shiftsection_id` INT NOT NULL,
  PRIMARY KEY (`id`),
<<<<<<< HEAD
  INDEX `fk_todoitems_todotexts1_idx` (`todothing_id` ASC) VISIBLE,
  INDEX `fk_todoitems_todosheets1_idx` (`todosheet_id` ASC) VISIBLE,
  INDEX `fk_todoitems_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_todoitems_todosheets1`
    FOREIGN KEY (`todosheet_id`)
    REFERENCES `csunvb_csu`.`todosheets` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_todoitems_todotexts1`
    FOREIGN KEY (`todothing_id`)
    REFERENCES `csunvb_csu`.`todothings` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_todoitems_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
=======
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_shift_lines_shift_sections1_idx` (`shiftsection_id` ASC),
  CONSTRAINT `fk_shift_lines_shift_sections1`
    FOREIGN KEY (`shiftsection_id`)
    REFERENCES `csunvb_csu`.`shiftsections` (`id`)
>>>>>>> master
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
<<<<<<< HEAD
-- Table `csunvb_csu`.`status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(25) NOT NULL,
  `displayname` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `slug` (`slug` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
=======
>>>>>>> master
-- Table `csunvb_csu`.`shiftmodels`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`shiftmodels` (
  `id` INT NOT NULL AUTO_INCREMENT,
<<<<<<< HEAD
  `name` VARCHAR(45) NOT NULL,
  `suggested` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idshiftmodels_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
ENGINE = InnoDB;
=======
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `suggested` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idshiftmodels_UNIQUE` (`id` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;
>>>>>>> master


-- -----------------------------------------------------
-- Table `csunvb_csu`.`shiftsheets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`shiftsheets` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `shiftmodel_id` INT NOT NULL,
  `base_id` INT NOT NULL,
  `status_id` INT NOT NULL,
  `dayboss_id` INT NULL,
  `nightboss_id` INT NULL,
  `dayteammate_id` INT NULL,
  `nightteammate_id` INT NULL,
  `daynova_id` INT NULL,
  `nightnova_id` INT NULL,
  PRIMARY KEY (`id`),
<<<<<<< HEAD
  UNIQUE INDEX `uniq` (`base_id` ASC, `date` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_shiftsheets_bases1_idx` (`base_id` ASC) VISIBLE,
  INDEX `fk_shiftSheets_status1_idx` (`status_id` ASC) VISIBLE,
  INDEX `fk_shiftSheets_users1_idx` (`dayboss_id` ASC) VISIBLE,
  INDEX `fk_shiftSheets_users2_idx` (`nightboss_id` ASC) VISIBLE,
  INDEX `fk_shiftSheets_users3_idx` (`dayteammate_id` ASC) VISIBLE,
  INDEX `fk_shiftSheets_users4_idx` (`nightteammate_id` ASC) VISIBLE,
  INDEX `fk_shiftSheets_novas1_idx` (`daynova_id` ASC) VISIBLE,
  INDEX `fk_shiftSheets_novas2_idx` (`nightnova_id` ASC) VISIBLE,
  INDEX `fk_shiftsheets_shiftmodels1_idx` (`shiftmodel_id` ASC) VISIBLE,
=======
  UNIQUE INDEX `uniq` (`base_id` ASC, `date` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_shiftsheets_bases1_idx` (`base_id` ASC),
  INDEX `fk_shiftSheets_status1_idx` (`status_id` ASC),
  INDEX `fk_shiftSheets_users1_idx` (`dayboss_id` ASC),
  INDEX `fk_shiftSheets_users2_idx` (`nightboss_id` ASC),
  INDEX `fk_shiftSheets_users3_idx` (`dayteammate_id` ASC),
  INDEX `fk_shiftSheets_users4_idx` (`nightteammate_id` ASC),
  INDEX `fk_shiftSheets_novas1_idx` (`daynova_id` ASC),
  INDEX `fk_shiftSheets_novas2_idx` (`nightnova_id` ASC),
  INDEX `fk_shiftsheets_shiftmodels1_idx` (`shiftmodel_id` ASC),
>>>>>>> master
  CONSTRAINT `fk_shiftSheets_novas1`
    FOREIGN KEY (`daynova_id`)
    REFERENCES `csunvb_csu`.`novas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_shiftSheets_novas2`
    FOREIGN KEY (`nightnova_id`)
    REFERENCES `csunvb_csu`.`novas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_shiftSheets_status1`
    FOREIGN KEY (`status_id`)
    REFERENCES `csunvb_csu`.`status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_shiftSheets_users1`
    FOREIGN KEY (`dayboss_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_shiftSheets_users2`
    FOREIGN KEY (`nightboss_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_shiftSheets_users3`
    FOREIGN KEY (`dayteammate_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_shiftSheets_users4`
    FOREIGN KEY (`nightteammate_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_shiftsheets_bases1`
    FOREIGN KEY (`base_id`)
    REFERENCES `csunvb_csu`.`bases` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_shiftsheets_shiftmodels1`
    FOREIGN KEY (`shiftmodel_id`)
    REFERENCES `csunvb_csu`.`shiftmodels` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
<<<<<<< HEAD
-- Table `csunvb_csu`.`shiftsections`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`shiftsections` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `title_UNIQUE` (`title` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`shiftactions`
=======
-- Table `csunvb_csu`.`shiftchecks`
>>>>>>> master
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`shiftchecks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `day` TINYINT(1) NOT NULL,
  `time` DATETIME NOT NULL DEFAULT current_timestamp(),
  `shiftsheet_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `shiftaction_id` INT NOT NULL,
  PRIMARY KEY (`id`),
<<<<<<< HEAD
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_shift_lines_shift_sections1_idx` (`shiftsection_id` ASC) VISIBLE,
  CONSTRAINT `fk_shift_lines_shift_sections1`
    FOREIGN KEY (`shiftsection_id`)
    REFERENCES `csunvb_csu`.`shiftsections` (`id`)
=======
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_shiftChecks_shiftSheets1_idx` (`shiftsheet_id` ASC),
  INDEX `fk_shiftChecks_users1_idx` (`user_id` ASC),
  INDEX `fk_shiftChecks_shiftActions1_idx` (`shiftaction_id` ASC),
  CONSTRAINT `fk_shiftChecks_shiftActions1`
    FOREIGN KEY (`shiftaction_id`)
    REFERENCES `csunvb_csu`.`shiftactions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_shiftChecks_shiftSheets1`
    FOREIGN KEY (`shiftsheet_id`)
    REFERENCES `csunvb_csu`.`shiftsheets` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_shiftChecks_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
>>>>>>> master
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`shiftcomments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`shiftcomments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `message` VARCHAR(200) NOT NULL,
  `time` DATETIME NOT NULL DEFAULT current_timestamp(),
  `carryOn` TINYINT(1) NOT NULL DEFAULT 0,
  `endOfCarryOn` DATE NULL,
  `user_id` INT NOT NULL,
  `shiftsheet_id` INT NOT NULL,
  `shiftaction_id` INT NOT NULL,
  PRIMARY KEY (`id`),
<<<<<<< HEAD
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_comments_users1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_comments_shiftSheets1_idx` (`shiftsheet_id` ASC) VISIBLE,
  INDEX `fk_comments_shiftActions1_idx` (`shiftaction_id` ASC) VISIBLE,
=======
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_comments_users1_idx` (`user_id` ASC),
  INDEX `fk_comments_shiftSheets1_idx` (`shiftsheet_id` ASC),
  INDEX `fk_comments_shiftActions1_idx` (`shiftaction_id` ASC),
>>>>>>> master
  CONSTRAINT `fk_comments_shiftActions1`
    FOREIGN KEY (`shiftaction_id`)
    REFERENCES `csunvb_csu`.`shiftactions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_shiftSheets1`
    FOREIGN KEY (`shiftsheet_id`)
    REFERENCES `csunvb_csu`.`shiftsheets` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`shiftmodel_has_shiftaction`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`shiftmodel_has_shiftaction` (
  `id` INT NOT NULL AUTO_INCREMENT,
<<<<<<< HEAD
  `day` TINYINT(1) NOT NULL,
  `time` DATETIME NOT NULL DEFAULT current_timestamp(),
  `shiftsheet_id` INT NOT NULL,
  `user_id` INT NOT NULL,
=======
>>>>>>> master
  `shiftaction_id` INT NOT NULL,
  `shiftmodel_id` INT NOT NULL,
  PRIMARY KEY (`id`),
<<<<<<< HEAD
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_shiftChecks_shiftSheets1_idx` (`shiftsheet_id` ASC) VISIBLE,
  INDEX `fk_shiftChecks_users1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_shiftChecks_shiftActions1_idx` (`shiftaction_id` ASC) VISIBLE,
  CONSTRAINT `fk_shiftChecks_shiftActions1`
=======
  UNIQUE INDEX `shiftmodelscol_has_shiftactions_UNIQUE` (`id` ASC),
  UNIQUE INDEX `uniqueactionpermodel` (`shiftaction_id` ASC, `shiftmodel_id` ASC),
  INDEX `fk_shiftactions_has_shiftmodels_shiftmodels1_idx` (`shiftmodel_id` ASC),
  INDEX `fk_shiftactions_has_shiftmodels_shiftactions1_idx` (`shiftaction_id` ASC),
  CONSTRAINT `fk_shiftactions_has_shiftmodels_shiftactions1`
>>>>>>> master
    FOREIGN KEY (`shiftaction_id`)
    REFERENCES `csunvb_csu`.`shiftactions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_shiftactions_has_shiftmodels_shiftmodels1`
    FOREIGN KEY (`shiftmodel_id`)
    REFERENCES `csunvb_csu`.`shiftmodels` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`todosheets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`todosheets` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `week` INT NOT NULL,
  `status_id` INT(11) NOT NULL,
  `base_id` INT NOT NULL,
  `template_name` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `model_name_UNIQUE` (`template_name` ASC),
  INDEX `fk_todosheets_bases1_idx` (`base_id` ASC),
  INDEX `fk_todosheets_status1` (`status_id` ASC),
  CONSTRAINT `fk_todosheets_bases1`
    FOREIGN KEY (`base_id`)
    REFERENCES `csunvb_csu`.`bases` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_todosheets_status1`
    FOREIGN KEY (`status_id`)
    REFERENCES `csunvb_csu`.`status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`todothings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`todothings` (
  `id` INT NOT NULL AUTO_INCREMENT,
<<<<<<< HEAD
  `shiftaction_id` INT NOT NULL,
  `shiftmodel_id` INT NOT NULL,
  INDEX `fk_shiftactions_has_shiftmodels_shiftmodels1_idx` (`shiftmodel_id` ASC) VISIBLE,
  INDEX `fk_shiftactions_has_shiftmodels_shiftactions1_idx` (`shiftaction_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `shiftmodelscol_has_shiftactions_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `uniqueactionpermodel` (`shiftaction_id` ASC, `shiftmodel_id` ASC) VISIBLE,
  CONSTRAINT `fk_shiftactions_has_shiftmodels_shiftactions1`
    FOREIGN KEY (`shiftaction_id`)
    REFERENCES `csunvb_csu`.`shiftactions` (`id`)
=======
  `description` VARCHAR(200) NOT NULL,
  `daything` TINYINT NOT NULL DEFAULT 1,
  `type` INT NOT NULL DEFAULT 1 COMMENT '1: done/not done\\n2: has a value',
  `display_order` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `text_UNIQUE` (`description` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`todos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`todos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `todothing_id` INT NOT NULL,
  `todosheet_id` INT NOT NULL,
  `user_id` INT NULL,
  `value` VARCHAR(45) NULL,
  `done_at` DATETIME NULL,
  `day_of_week` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_todoitems_todotexts1_idx` (`todothing_id` ASC),
  INDEX `fk_todoitems_todosheets1_idx` (`todosheet_id` ASC),
  INDEX `fk_todoitems_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_todoitems_todosheets1`
    FOREIGN KEY (`todosheet_id`)
    REFERENCES `csunvb_csu`.`todosheets` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_todoitems_todotexts1`
    FOREIGN KEY (`todothing_id`)
    REFERENCES `csunvb_csu`.`todothings` (`id`)
>>>>>>> master
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_todoitems_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`tokens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`tokens` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `value` VARCHAR(50) NOT NULL,
  `validity` DATETIME NOT NULL,
  `user_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `token_UNIQUE` (`value` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_table1_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_table1_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `csunvb_csu`.`tokens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `csunvb_csu`.`tokens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `value` VARCHAR(50) NOT NULL,
  `validity` DATETIME NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `token_UNIQUE` (`value` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_table1_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_table1_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `csunvb_csu`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
<<<<<<< HEAD
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
=======
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
>>>>>>> master
