# Project database structure

The database was created using the MQL Workbench tool. To generate the database needed to run the application it is strictly important to execute MySQL commands in the exact order found in this document.

It is worth saying that a MySQL command only ends in ";" so it doesn't matter how many lines it has. Some database tools allow you to select all commands at once u (Ctrl + A on Windows and Linux) and execute. And in other tools it may be necessary to execute one command after another.

### The commands

CREATE DATABASE goal;

CREATE TABLE `goal`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(50) NOT NULL,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE `goal`.`goals` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(50) NOT NULL,
  `description` VARCHAR(250) NULL,
  `price` DECIMAL(10,2) NULL,
  `finish_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE goals add CONSTRAINT fk_01 FOREING KEY (id_user) REFERENCES user (id);

CREATE TABLE `goal`.`goal_item` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(50) NOT NULL,
  `description` VARCHAR(250) NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `id_goal` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE goal_item ADD CONSTRAINT fk_02 FOREIGN KEY (id_goal) REFERENCES goals (id);
