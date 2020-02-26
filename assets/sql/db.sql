-- MySQL Workbench Synchronization
-- Generated: 2020-02-20 11:32
-- Model: New Model
-- Version: 1.0
-- Project: Node REST API
-- Author: Fabio Messias Dias

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE TABLE IF NOT EXISTS `product` (
  `id_product` INT(11) NOT NULL AUTO_INCREMENT,
  `id_category` INT(11) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `description` VARCHAR(255) NULL DEFAULT NULL,
  `price` DECIMAL(8,2) NOT NULL,
  `url` VARCHAR(50) NOT NULL,
  `createdAt` TIMESTAMP DEFAULT NOW(),
  `updatedAt` TIMESTAMP DEFAULT NOW(),
  PRIMARY KEY (`id_product`),
  INDEX `fk_product_category_idx` (`id_category` ASC),
  UNIQUE INDEX `url_UNIQUE` (`url` ASC),
  CONSTRAINT `fk_product_category`
    FOREIGN KEY (`id_category`)
    REFERENCES `category` (`id_category`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB 
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `category` (
  `id_category` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `url` VARCHAR(50) NOT NULL,
  `createdAt` TIMESTAMP NOT NULL DEFAULT NOW(),
  `updatedAt` TIMESTAMP NOT NULL DEFAULT NOW(),
  PRIMARY KEY (`id_category`),
  UNIQUE INDEX `url_UNIQUE` (`url` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- Optional INSERTS: 
INSERT INTO `category` (`name`, `url`) 
VALUES 
('1', 'Celulares', 'celular'),
('2', 'Computadores', 'computadores'),
('3', 'NoteBooks', 'notebook');

INSERT INTO `product` (`id_product`, `id_category`, `name`, `description`, `price`, `url`) 
VALUES 
('1', '1', 'iPhone Xs Max', 'New iPhone Xs Max', '5789.99', 'iphone-xs-max'),
('2', '1', 'Galaxy S10', 'New Galaxy S10', '4367.90', 'galaxy-s10');

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;