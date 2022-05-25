-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`User` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(45) NULL,
  `name` VARCHAR(45) NULL,
  `surname` VARCHAR(45) NULL,
  `following_id` VARCHAR(45) NULL,
  `followers` VARCHAR(45) NULL,
  `watchlist` VARCHAR(45) NULL,
  `favorite_movie_id` INT NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`WatchList`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`WatchList` (
  `wlist_id` INT NOT NULL,
  `movie_id` INT NOT NULL,
  `User_user_id` INT NOT NULL,
  PRIMARY KEY (`wlist_id`, `movie_id`),
  INDEX `fk_WatchList_User1_idx` (`User_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_WatchList_User1`
    FOREIGN KEY (`User_user_id`)
    REFERENCES `mydb`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`WatchedMovies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`WatchedMovies` (
  `watched_id` INT NOT NULL,
  `movie_id` VARCHAR(45) NOT NULL,
  `User_user_id` INT NOT NULL,
  PRIMARY KEY (`watched_id`, `movie_id`),
  INDEX `fk_WatchedMovies_User1_idx` (`User_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_WatchedMovies_User1`
    FOREIGN KEY (`User_user_id`)
    REFERENCES `mydb`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Movie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Movie` (
  `movie_id` INT NOT NULL,
  `movie_name` VARCHAR(45) NULL,
  `movie_duration` INT NULL,
  `movie_year` INT NULL,
  `movie_description` VARCHAR(45) NULL,
  `movie_category` VARCHAR(45) NULL,
  `WatchList_wlist_id` INT NOT NULL,
  `WatchList_movie_id` INT NOT NULL,
  `WatchedMovies_watched_id` INT NOT NULL,
  `WatchedMovies_movie_id` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`movie_id`),
  INDEX `fk_Movie_WatchList1_idx` (`WatchList_wlist_id` ASC, `WatchList_movie_id` ASC) VISIBLE,
  INDEX `fk_Movie_WatchedMovies1_idx` (`WatchedMovies_watched_id` ASC, `WatchedMovies_movie_id` ASC) VISIBLE,
  CONSTRAINT `fk_Movie_WatchList1`
    FOREIGN KEY (`WatchList_wlist_id` , `WatchList_movie_id`)
    REFERENCES `mydb`.`WatchList` (`wlist_id` , `movie_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Movie_WatchedMovies1`
    FOREIGN KEY (`WatchedMovies_watched_id` , `WatchedMovies_movie_id`)
    REFERENCES `mydb`.`WatchedMovies` (`watched_id` , `movie_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Following`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Following` (
  `following_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `User_user_id` INT NOT NULL,
  PRIMARY KEY (`following_id`, `user_id`),
  INDEX `fk_Following_User1_idx` (`User_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_Following_User1`
    FOREIGN KEY (`User_user_id`)
    REFERENCES `mydb`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Followers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Followers` (
  `follewer_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `User_user_id` INT NOT NULL,
  PRIMARY KEY (`follewer_id`, `user_id`),
  INDEX `fk_Followers_User1_idx` (`User_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_Followers_User1`
    FOREIGN KEY (`User_user_id`)
    REFERENCES `mydb`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Cast`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Cast` (
  `act_id` INT NOT NULL,
  `movie_id` VARCHAR(45) NOT NULL,
  `role` VARCHAR(45) NULL,
  `Movie_movie_id` INT NOT NULL,
  PRIMARY KEY (`act_id`, `movie_id`),
  INDEX `fk_Cast_Movie1_idx` (`Movie_movie_id` ASC) VISIBLE,
  CONSTRAINT `fk_Cast_Movie1`
    FOREIGN KEY (`Movie_movie_id`)
    REFERENCES `mydb`.`Movie` (`movie_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Actor/Actress`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Actor/Actress` (
  `act_id` INT NOT NULL,
  `act_name` VARCHAR(45) NOT NULL,
  `act_surname` VARCHAR(45) NULL,
  `act_desc` VARCHAR(45) NULL,
  `Cast_act_id` INT NOT NULL,
  `Cast_movie_id` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`act_id`),
  INDEX `fk_Actor/Actress_Cast_idx` (`Cast_act_id` ASC, `Cast_movie_id` ASC) VISIBLE,
  CONSTRAINT `fk_Actor/Actress_Cast`
    FOREIGN KEY (`Cast_act_id` , `Cast_movie_id`)
    REFERENCES `mydb`.`Cast` (`act_id` , `movie_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Director`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Director` (
  `dir_id` INT NOT NULL,
  `movie_id` VARCHAR(45) NOT NULL,
  `Cast_act_id` INT NOT NULL,
  `Cast_movie_id` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`dir_id`, `movie_id`),
  INDEX `fk_Director_Cast1_idx` (`Cast_act_id` ASC, `Cast_movie_id` ASC) VISIBLE,
  CONSTRAINT `fk_Director_Cast1`
    FOREIGN KEY (`Cast_act_id` , `Cast_movie_id`)
    REFERENCES `mydb`.`Cast` (`act_id` , `movie_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`FavoriteMovies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`FavoriteMovies` (
  `fav_id` INT NOT NULL AUTO_INCREMENT,
  `movie_id` INT NOT NULL,
  `User_user_id` INT NOT NULL,
  PRIMARY KEY (`fav_id`, `movie_id`),
  INDEX `fk_FavoriteMovies_User1_idx` (`User_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_FavoriteMovies_User1`
    FOREIGN KEY (`User_user_id`)
    REFERENCES `mydb`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`UserActivity`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`UserActivity` (
  `user_id` INT NOT NULL,
  `movie_id` INT NULL,
  `movie_is_watch` TINYINT NULL,
  `user_rating` INT NULL,
  `movie_is_watchlist` TINYINT NULL,
  `user_review` VARCHAR(45) NULL,
  `User_user_id` INT NOT NULL,
  PRIMARY KEY (`user_id`),
  INDEX `fk_UserActivity_User1_idx` (`User_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_UserActivity_User1`
    FOREIGN KEY (`User_user_id`)
    REFERENCES `mydb`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Rating`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Rating` (
  `movie_id` INT NOT NULL,
  `mg_rating` VARCHAR(45) NULL,
  `imdb_rating` VARCHAR(45) NULL,
  `Movie_movie_id` INT NOT NULL,
  PRIMARY KEY (`movie_id`),
  INDEX `fk_Rating_Movie1_idx` (`Movie_movie_id` ASC) VISIBLE,
  CONSTRAINT `fk_Rating_Movie1`
    FOREIGN KEY (`Movie_movie_id`)
    REFERENCES `mydb`.`Movie` (`movie_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`MoreLikeThis`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`MoreLikeThis` (
  `movie_id` INT NOT NULL,
  `morelikethis_id` INT NOT NULL,
  `Movie_movie_id` INT NOT NULL,
  PRIMARY KEY (`movie_id`, `morelikethis_id`),
  INDEX `fk_MoreLikeThis_Movie1_idx` (`Movie_movie_id` ASC) VISIBLE,
  CONSTRAINT `fk_MoreLikeThis_Movie1`
    FOREIGN KEY (`Movie_movie_id`)
    REFERENCES `mydb`.`Movie` (`movie_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Review`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Review` (
  `review_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `movie_id` INT NOT NULL,
  `review` VARCHAR(200) NULL,
  `Movie_movie_id` INT NOT NULL,
  `User_user_id` INT NOT NULL,
  PRIMARY KEY (`review_id`, `user_id`, `movie_id`),
  INDEX `fk_Review_Movie1_idx` (`Movie_movie_id` ASC) VISIBLE,
  INDEX `fk_Review_User1_idx` (`User_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_Review_Movie1`
    FOREIGN KEY (`Movie_movie_id`)
    REFERENCES `mydb`.`Movie` (`movie_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Review_User1`
    FOREIGN KEY (`User_user_id`)
    REFERENCES `mydb`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Description`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Description` (
  `desc_id` INT NOT NULL,
  `movie_id` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  PRIMARY KEY (`desc_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Photos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Photos` (
  `photo_id` INT NOT NULL AUTO_INCREMENT,
  `movie_id` INT NOT NULL,
  `photo` VARCHAR(45) NULL,
  `Movie_movie_id` INT NOT NULL,
  PRIMARY KEY (`photo_id`, `movie_id`),
  INDEX `fk_Photos_Movie1_idx` (`Movie_movie_id` ASC) VISIBLE,
  CONSTRAINT `fk_Photos_Movie1`
    FOREIGN KEY (`Movie_movie_id`)
    REFERENCES `mydb`.`Movie` (`movie_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
