CREATE TABLE IF NOT EXISTS `Users` (
`UserId` int(10) unsigned NOT NULL AUTO_INCREMENT,
`FirstName` varchar(128) NOT NULL,
`LastName` varchar(128) NULL DEFAULT NULL,
`Email` varchar(128) NOT NULL,
`Course` varchar(128) NOT NULL,
`Password` varchar(128) NOT NULL,
`Reputation` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
PRIMARY KEY (`UserId`)
);

CREATE TABLE IF NOT EXISTS `Tasks` (
`TaskId` int(10) unsigned NOT NULL AUTO_INCREMENT,
`Title` varchar(128) NOT NULL,
`TaskType` varchar(128) NOT NULL,
`Description` varchar(4096) NOT NULL,
`Pages` int(5) unsigned NOT NULL,
`Words` int(10) unsigned NOT NULL,
`FileFormat` char(128) NOT NULL,
`FilePath` varchar(250) NOT NULL,
`ClaimDate` datetime NOT NULL,
`CompleteDate` datetime NOT NULL,
`Notes` varchar(300) DEFAULT NULL,
PRIMARY KEY (`TaskId`),
UNIQUE KEY (`FilePath`)
);

CREATE TABLE IF NOT EXISTS `Owned` (
`Numbered` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`UserId` int(10) unsigned NOT NULL,
`TaskId` int(10) unsigned NOT NULL ,
PRIMARY KEY (`Numbered`),
CONSTRAINT FOREIGN KEY (`UserId`) REFERENCES USERS(`UserId`)ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY (`TaskId`) REFERENCES TASKS(`TaskId`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `Flag` (
`Numbered` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`TaskId` int(10) unsigned NOT NULL,
`IsFlagged` boolean NOT NULL DEFAULT 0,
PRIMARY KEY (`Numbered`),
CONSTRAINT FOREIGN KEY (`TaskId`) REFERENCES TASKS(`TaskId`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `Banned` (
`Numbered` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`UserId` int(10) unsigned NOT NULL,
`IsBanned` boolean NOT NULL DEFAULT 0,
PRIMARY KEY (`Numbered`),
CONSTRAINT FOREIGN KEY (`UserId`) REFERENCES Users(`UserId`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `Tags` (
`TagId` int(10) unsigned NOT NULL AUTO_INCREMENT,
`Tag` varchar(128) NOT NULL,
PRIMARY KEY (`TagId`)
);

CREATE TABLE IF NOT EXISTS `TaskTags` (
`Numbered` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`TaskId` int(10) unsigned NOT NULL,
`TagId` int(10) unsigned NOT NULL,
PRIMARY KEY (`Numbered`),
CONSTRAINT FOREIGN KEY (`TaskId`) REFERENCES TASKS(`TaskId`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY (`TagId`) REFERENCES TAGS(`TagId`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `StatusTable` (
`Numbered` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`TaskId` int(10) unsigned NOT NULL,
`Status` int(1) unsigned NOT NULL DEFAULT 0,
PRIMARY KEY (`Numbered`),
CONSTRAINT FOREIGN KEY (`TaskId`) REFERENCES TASKS(`TaskId`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE upload (
id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(30) NOT NULL,
type VARCHAR(30) NOT NULL,
size INT NOT NULL,
content MEDIUMBLOB NOT NULL,
PRIMARY KEY(id)
);












