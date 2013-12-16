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
  `row_Choice` INT NULL,
  `col_Choice` INT NULL,
  `Active` INT NULL,
  PRIMARY KEY (`idPlayers`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `AwesomeTicTacToe`.`Game`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `AwesomeTicTacToe`.`Game` ;

CREATE TABLE IF NOT EXISTS `AwesomeTicTacToe`.`Game` (
  `idGame` INT NOT NULL AUTO_INCREMENT,
  `game_Name` VARCHAR(45) NULL,
  `turn_Count` INT NULL,
  `lastPos` INT NULL,
  `board_State` VARCHAR(100) NULL,
  `last_Player` INT NULL,
  `Active` INT NULL DEFAULT 1,
  PRIMARY KEY (`idGame`),
  UNIQUE INDEX `idGame_UNIQUE` (`idGame` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
