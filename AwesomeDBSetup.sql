SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `AwesomeTicTacToe` ;
CREATE SCHEMA IF NOT EXISTS `AwesomeTicTacToe` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `AwesomeTicTacToe` ;

-- -----------------------------------------------------
-- Table `AwesomeTicTacToe`.`Players`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AwesomeTicTacToe`.`Players` ;

CREATE TABLE IF NOT EXISTS `AwesomeTicTacToe`.`Players` (
  `idPlayers` INT NOT NULL AUTO_INCREMENT,
  `player_Name` VARCHAR(45) NULL,
  `game_ID` INT NULL,
  PRIMARY KEY (`idPlayers`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AwesomeTicTacToe`.`Game`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AwesomeTicTacToe`.`Game` ;

CREATE TABLE IF NOT EXISTS `AwesomeTicTacToe`.`Game` (
  `idGame` INT NOT NULL AUTO_INCREMENT,
  `pos1` INT NULL,
  `pos2` INT NULL,
  `pos3` INT NULL,
  `pos4` INT NULL,
  `pos5` INT NULL,
  `pos6` INT NULL,
  `pos7` INT NULL,
  `pos8` INT NULL,
  `pos9` INT NULL,
  `pos10` INT NULL,
  `pos11` INT NULL,
  `pos12` INT NULL,
  `pos13` INT NULL,
  `pos14` INT NULL,
  `pos15` INT NULL,
  `pos16` INT NULL,
  `pos17` INT NULL,
  `pos18` INT NULL,
  `pos19` INT NULL,
  `pos20` INT NULL,
  `pos21` INT NULL,
  `pos22` INT NULL,
  `pos23` INT NULL,
  `pos24` INT NULL,
  `pos25` INT NULL,
  `turn_Count` INT NULL,
  PRIMARY KEY (`idGame`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
