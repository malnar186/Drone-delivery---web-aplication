-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 05, 2023 at 05:00 PM
-- Server version: 8.0.32-0ubuntu0.22.04.2
-- PHP Version: 8.1.2-1ubuntu2.11

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iwa_2022_vz_projekt`
--
CREATE SCHEMA IF NOT EXISTS `iwa_2022_vz_projekt`;
USE `iwa_2022_vz_projekt`;

-- --------------------------------------------------------

--
-- Table structure for table `iwa_2022_vz_projekt`.`tip_korisnika`
--

CREATE TABLE IF NOT EXISTS `iwa_2022_vz_projekt`.`tip_korisnika` (
  `tip_korisnika_id` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`tip_korisnika_id`))
ENGINE = InnoDB;
-- --------------------------------------------------------
--
-- Table structure for table `iwa_2022_vz_projekt`.`vrsta_drona`
--

CREATE TABLE IF NOT EXISTS `iwa_2022_vz_projekt`.`vrsta_drona` (
  `vrsta_drona_id` INT NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(45) NOT NULL,
  `minKM` FLOAT NOT NULL,
  `maxKM` FLOAT NOT NULL,
  `cijenaPoKM` FLOAT NOT NULL,
  PRIMARY KEY (`vrsta_drona_id`)
) ENGINE=InnoDB;

-- --------------------------------------------------------
--
-- Table structure for table `iwa_2022_vz_projekt`.`korisnik`
--

CREATE TABLE IF NOT EXISTS `iwa_2022_vz_projekt`.`korisnik` (
  `korisnik_id` INT NOT NULL AUTO_INCREMENT,
  `tip_korisnika_id` INT NOT NULL,
  `vrsta_drona_id` INT DEFAULT NULL,
  `korime` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `lozinka` VARCHAR(100) NOT NULL,
  `ime` VARCHAR(50) NOT NULL,
  `prezime` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`korisnik_id`),
  INDEX `fk_korisnik_tip_korisnika_idx` (`tip_korisnika_id` ASC),
  INDEX `fk_korisnik_vrsta_drona1_idx` (`vrsta_drona_id` ASC),
  CONSTRAINT `fk_korisnik_tip_korisnika` 
    FOREIGN KEY (`tip_korisnika_id`)
    REFERENCES `iwa_2022_vz_projekt`.`tip_korisnika` (`tip_korisnika_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_korisnik_vrsta_drona1` 
    FOREIGN KEY (`vrsta_drona_id`) 
    REFERENCES `iwa_2022_vz_projekt`.`vrsta_drona` (`vrsta_drona_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB;



-- --------------------------------------------------------

--
-- Table structure for table `dron`
--

CREATE TABLE IF NOT EXISTS `iwa_2022_vz_projekt`.`dron` (
  `dron_id` INT NOT NULL AUTO_INCREMENT,
  `vrsta_drona_id` INT NOT NULL,
  `poveznica_slika` VARCHAR(500) NOT NULL,
  `naziv` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`dron_id`),
  INDEX `fk_dron_vrsta_drona1_idx` (`vrsta_drona_id` ASC),
  CONSTRAINT `fk_dron_vrsta_drona1` 
    FOREIGN KEY (`vrsta_drona_id`) 
    REFERENCES `iwa_2022_vz_projekt`.`vrsta_drona` (`vrsta_drona_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION


) ENGINE=InnoDB;

-- --------------------------------------------------------
--
-- Table structure for table `dostava`
--

CREATE TABLE IF NOT EXISTS `iwa_2022_vz_projekt`.`dostava` (
  `dostava_id` INT NOT NULL AUTO_INCREMENT,
  `dron_id` INT DEFAULT NULL,
  `korisnik_id` INT NOT NULL,
  `datum_vrijeme_dostave` DATETIME DEFAULT NULL,
  `datum_vrijeme_zahtjeva` DATETIME NOT NULL,
  `opis_posiljke` VARCHAR(45) NOT NULL,
  `napomene` VARCHAR(500) DEFAULT NULL,
  `adresa_dostave` VARCHAR(100) NOT NULL,
  `adresa_polazista` VARCHAR(100) NOT NULL,
  `dostavaKM` FLOAT NOT NULL,
  `dostavaKG` FLOAT NOT NULL,
  `hitnost` TINYINT NOT NULL,
  `ukupna_cijena` FLOAT DEFAULT NULL,
  `status` TINYINT NOT NULL,
  PRIMARY KEY (`dostava_id`),
  INDEX `fk_termini_korisnik1_idx` (`korisnik_id` ASC),
  INDEX `fk_dostava_dron1_idx` (`dron_id` ASC),
  CONSTRAINT `fk_dostava_dron1` 
      FOREIGN KEY (`dron_id`) 
      REFERENCES `iwa_2022_vz_projekt`.`dron` (`dron_id`)  
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  CONSTRAINT `fk_termini_korisnik1` 
      FOREIGN KEY (`korisnik_id`) 
      REFERENCES `iwa_2022_vz_projekt`.`korisnik` (`korisnik_id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
) ENGINE=InnoDB;


CREATE USER 'iwa_2022'@'localhost' IDENTIFIED BY 'foi2022';
GRANT SELECT, INSERT, TRIGGER, UPDATE, DELETE ON TABLE `iwa_2022_vz_projekt`.* TO 'iwa_2022'@'localhost'; 

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
