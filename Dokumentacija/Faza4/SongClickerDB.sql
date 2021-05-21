-- MySQL Script generated by MySQL Workbench
-- Fri May 21 14:11:58 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema SongClickerDB
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `SongClickerDB` ;

-- -----------------------------------------------------
-- Schema SongClickerDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `SongClickerDB` ;
USE `SongClickerDB` ;

-- -----------------------------------------------------
-- Table `SongClickerDB`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SongClickerDB`.`User` ;

CREATE TABLE IF NOT EXISTS `SongClickerDB`.`User` (
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `type` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`username`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SongClickerDB`.`Genre`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SongClickerDB`.`Genre` ;

CREATE TABLE IF NOT EXISTS `SongClickerDB`.`Genre` (
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`name`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SongClickerDB`.`Playlist`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SongClickerDB`.`Playlist` ;

CREATE TABLE IF NOT EXISTS `SongClickerDB`.`Playlist` (
  `idP` INT NOT NULL,
  `difficulty` VARCHAR(45) NOT NULL,
  `genre` VARCHAR(45) NOT NULL,
  `number` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idP`),
  INDEX `FK_genre_Playlist_idx` (`genre` ASC),
  CONSTRAINT `FK_genre_Playlist`
    FOREIGN KEY (`genre`)
    REFERENCES `SongClickerDB`.`Genre` (`name`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SongClickerDB`.`Song`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SongClickerDB`.`Song` ;

CREATE TABLE IF NOT EXISTS `SongClickerDB`.`Song` (
  `idS` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `artist` VARCHAR(45) NOT NULL,
  `path` VARCHAR(45) NOT NULL,
  `idP` INT NOT NULL,
  PRIMARY KEY (`idS`),
  INDEX `FK_idP_Song_idx` (`idP` ASC),
  CONSTRAINT `FK_idP_Song`
    FOREIGN KEY (`idP`)
    REFERENCES `SongClickerDB`.`Playlist` (`idP`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SongClickerDB`.`User_info`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SongClickerDB`.`User_info` ;

CREATE TABLE IF NOT EXISTS `SongClickerDB`.`User_info` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `genre` VARCHAR(45) NOT NULL,
  `points` INT NOT NULL DEFAULT 0,
  `tokens` INT NOT NULL DEFAULT 0,
  INDEX `FK_genre_User_info_idx` (`genre` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_genre_User_info`
    FOREIGN KEY (`genre`)
    REFERENCES `SongClickerDB`.`Genre` (`name`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_username_User_info`
    FOREIGN KEY (`username`)
    REFERENCES `SongClickerDB`.`User` (`username`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SongClickerDB`.`Mistake_log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SongClickerDB`.`Mistake_log` ;

CREATE TABLE IF NOT EXISTS `SongClickerDB`.`Mistake_log` (
  `idM` INT NOT NULL,
  `idS` INT NOT NULL,
  PRIMARY KEY (`idM`),
  INDEX `FK_idS_MistakeLog_idx` (`idS` ASC),
  CONSTRAINT `FK_idS_Mistake_log`
    FOREIGN KEY (`idS`)
    REFERENCES `SongClickerDB`.`Song` (`idS`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SongClickerDB`.`Moderator_change_log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SongClickerDB`.`Moderator_change_log` ;

CREATE TABLE IF NOT EXISTS `SongClickerDB`.`Moderator_change_log` (
  `idC` INT NOT NULL,
  `oldSongName` VARCHAR(45) NOT NULL,
  `oldSongArtist` VARCHAR(45) NOT NULL,
  `newSongName` VARCHAR(45) NOT NULL,
  `newSongArtist` VARCHAR(45) NOT NULL,
  `operation` CHAR(1) NOT NULL,
  `dateAndTime` VARCHAR(45) NOT NULL,
  `moderatorUsername` VARCHAR(45) NOT NULL,
  `idS` INT NOT NULL,
  PRIMARY KEY (`idC`),
  INDEX `FK_modUsername_Changes_idx` (`moderatorUsername` ASC),
  INDEX `FK_idS_Changes_idx` (`idS` ASC),
  CONSTRAINT `FK_modUsername_Moderator_chnage_log`
    FOREIGN KEY (`moderatorUsername`)
    REFERENCES `SongClickerDB`.`User` (`username`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `FK_idS_Moderator_change_log`
    FOREIGN KEY (`idS`)
    REFERENCES `SongClickerDB`.`Song` (`idS`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
