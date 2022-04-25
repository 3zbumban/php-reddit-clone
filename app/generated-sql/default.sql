
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- post
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `post`;

CREATE TABLE `post`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `uid` CHAR(39) NOT NULL,
    `title` VARCHAR(140) NOT NULL,
    `text` TEXT NOT NULL,
    `createdAt` DATETIME NOT NULL,
    `threadId` INTEGER NOT NULL,
    `userId` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `post_fi_f4311f` (`userId`),
    INDEX `post_fi_74b402` (`threadId`),
    CONSTRAINT `post_fk_f4311f`
        FOREIGN KEY (`userId`)
        REFERENCES `user` (`id`),
    CONSTRAINT `post_fk_74b402`
        FOREIGN KEY (`threadId`)
        REFERENCES `thread` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- thread
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `thread`;

CREATE TABLE `thread`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `uid` CHAR(39) NOT NULL,
    `name` VARCHAR(140) NOT NULL,
    `createdAt` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(128) NOT NULL,
    `password` VARCHAR(128) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- comment
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `comment`;

CREATE TABLE `comment`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `uid` CHAR(39) NOT NULL,
    `text` TEXT NOT NULL,
    `createdAt` DATETIME NOT NULL,
    `postId` INTEGER NOT NULL,
    `userId` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `comment_fi_72d1d6` (`postId`),
    INDEX `comment_fi_f4311f` (`userId`),
    CONSTRAINT `comment_fk_72d1d6`
        FOREIGN KEY (`postId`)
        REFERENCES `post` (`id`),
    CONSTRAINT `comment_fk_f4311f`
        FOREIGN KEY (`userId`)
        REFERENCES `user` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- vote
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `vote`;

CREATE TABLE `vote`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `vote` INTEGER NOT NULL,
    `postId` INTEGER NOT NULL,
    `userId` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `vote_fi_72d1d6` (`postId`),
    INDEX `vote_fi_f4311f` (`userId`),
    CONSTRAINT `vote_fk_72d1d6`
        FOREIGN KEY (`postId`)
        REFERENCES `post` (`id`),
    CONSTRAINT `vote_fk_f4311f`
        FOREIGN KEY (`userId`)
        REFERENCES `user` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
