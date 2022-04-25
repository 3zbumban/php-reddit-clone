<?php
use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1650852196.
 * Generated on 2022-04-25 02:03:16 by root 
 */
class PropelMigration_1650852196 
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        $connection_default = <<< 'EOT'

# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

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

CREATE TABLE `thread`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `uid` CHAR(39) NOT NULL,
    `name` VARCHAR(140) NOT NULL,
    `createdAt` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(128) NOT NULL,
    `password` VARCHAR(128) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

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

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
EOT;

        return array(
            'default' => $connection_default,
        );
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        $connection_default = <<< 'EOT'

# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `post`;

DROP TABLE IF EXISTS `thread`;

DROP TABLE IF EXISTS `user`;

DROP TABLE IF EXISTS `comment`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
EOT;

        return array(
            'default' => $connection_default,
        );
    }

}