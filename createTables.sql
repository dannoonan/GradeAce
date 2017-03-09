CREATE TABLE IF NOT EXISTS `Users` (
`UserId` int(10) unsigned NOT NULL AUTO_INCREMENT,
`FirstName` varchar(128) NOT NULL,
`LastName` varchar(128) NULL DEFAULT NULL,
`Email` varchar(128) NOT NULL,
`Course` varchar(128) NOT NULL,
`Password` varchar(128) NOT NULL,
`Reputation` SMALLINT UNSIGNED NOT NULL,
PRIMARY KEY (`UserId`)
);

CREATE TABLE IF NOT EXISTS `Tasks` (
`UserId` int(20) unsigned NOT NULL,
`TaskId` int(10) unsigned NOT NULL AUTO_INCREMENT,
`Title` varchar(128) NOT NULL,
`TaskType` varchar(128) NOT NULL,
`Description` varchar(4096) DEFAULT NULL,
`Tags` varchar(1000) DEFAULT NULL,
`Pages` int(5) unsigned NOT NULL,
`Words` int(10) unsigned NOT NULL,
`FileFormat` char(128) NOT NULL,
`FilePath` varchar(250) NOT NULL,
`ClaimDate` datetime NOT NULL,
`CompleteDate` datetime NOT NULL,
PRIMARY KEY (`TaskId`),
UNIQUE KEY (`FilePath`),
KEY `fk_TaskOwnerId` (`UserId`),
CONSTRAINT `fk_TaskOwnerId` FOREIGN KEY (`UserId`) REFERENCES `Users` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE
);



CREATE TABLE IF NOT EXISTS `CompleteTasks` (
`TaskId` int(10) unsigned NOT NULL AUTO_INCREMENT,
`UserId` int(20) unsigned NOT NULL ,
`Title` varchar(128) NOT NULL,
`Notes` varchar(300) DEFAULT NULL,
PRIMARY KEY (`TaskId`),
KEY `fk_two_TaskOwnerId` (`UserId`),
CONSTRAINT `fk_two_TaskOwnerId` FOREIGN KEY (`UserId`) REFERENCES `Users` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE
);
