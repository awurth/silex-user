CREATE TABLE `user` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `username` VARCHAR(180) NOT NULL,
  `email` VARCHAR(180) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `salt` VARCHAR(255) DEFAULT NULL,
  `enabled` TINYINT(1) NOT NULL,
  `last_login` DATETIME DEFAULT NULL,
  `roles` LONGTEXT NOT NULL COMMENT '(DC2Type:array)',
  `confirmation_token` VARCHAR(180) DEFAULT NULL,
  UNIQUE INDEX `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE INDEX `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE INDEX `UNIQ_8D93D649C05FB297` (`confirmation_token`),
  PRIMARY KEY(`id`)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
