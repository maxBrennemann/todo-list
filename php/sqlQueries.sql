CREATE TABLE `todo`.`lists` (`id` INT NOT NULL AUTO_INCREMENT , `userId` INT NOT NULL , `title` VARCHAR(256) NOT NULL , `description` VARCHAR(256) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `todo`.`todos` (`id` INT NOT NULL AUTO_INCREMENT , `listId` INT NOT NULL , `title` VARCHAR(256) NOT NULL , `description` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `todo`.`user` (`id` INT NOT NULL AUTO_INCREMENT , `username` INT NOT NULL , `email` INT NOT NULL , `pwHash` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `todo`.`files` (`id` INT NOT NULL AUTO_INCREMENT , `idToDo` INT NOT NULL , `fileName` VARCHAR(256) NOT NULL , `uploadDate` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `lists` ADD `creationTime` TIMESTAMP NOT NULL AFTER `description`;

ALTER TABLE `todos` ADD `creationTime` INT NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `description`, ADD `dueOn` DATETIME NULL AFTER `creationTime`;

ALTER TABLE `todos` ADD `state` ENUM('active', 'deleted') NOT NULL AFTER `description`;
ALTER TABLE `todos` CHANGE `state` `state` ENUM('active','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active';

/* constraints */
ALTER TABLE `lists` ADD CONSTRAINT `deleteOnUserDelete` FOREIGN KEY (`userId`) REFERENCES `user`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `todos` ADD CONSTRAINT `deleteOnListDelete` FOREIGN KEY (`listId`) REFERENCES `lists`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `files` ADD CONSTRAINT `deleteOnToDoDelete` FOREIGN KEY (`idToDo`) REFERENCES `todos`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/* additional tables */
CREATE TABLE `todo`.`lists_to_users` (`idList` INT NOT NULL , `idAdditionalUser` INT NOT NULL ) ENGINE = InnoDB;

ALTER TABLE `lists_to_users` ADD UNIQUE(`idList`, `idAdditionalUser`);

ALTER TABLE `user` CHANGE `username` `username` VARCHAR(32) NOT NULL;

ALTER TABLE `user` CHANGE `email` `email` VARCHAR(32) NOT NULL;

ALTER TABLE `user` CHANGE `pwHash` `pwHash` VARCHAR(64) NOT NULL;

ALTER TABLE `user` CHANGE `username` `username` VARCHAR(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;

ALTER TABLE `todos` DROP `creationTime`;

ALTER TABLE `todos` ADD `creationTime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `description`;

ALTER TABLE `lists` CHANGE `description` `description` VARCHAR(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;

ALTER TABLE `lists` CHANGE `creationTime` `creationTime` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `todos` CHANGE `state` `state` ENUM('active','deleted','done') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active';