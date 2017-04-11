SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


--
-- Database: `gradeace`
--

CREATE DATABASE IF NOT EXISTS `gradeace` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gradeace`;

--
-- Stored Procedures
--

DELIMITER $$

DROP PROCEDURE IF EXISTS `addTask`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addTask`(IN `Title` VARCHAR(128), IN `TaskType` VARCHAR(128), IN `TaskField` VARCHAR(128), IN `Description` VARCHAR(128), IN `Pages` INT(5), IN `Words` INT(10), IN `FileFormat` CHAR(128), IN `FilePath` VARCHAR(128), IN `ClaimDate` DATETIME, IN `CompleteDate` DATETIME, IN `Notes` VARCHAR(300))
    READS SQL DATA
BEGIN
INSERT INTO `tasks`(TaskId, Title, TaskType, TaskField, Description, Pages, Words, FileFormat, FilePath, ClaimDate, CompleteDate, Notes) VALUES (NULL, Title, TaskType, TaskField, Description, Pages, Words, FileFormat, FilePath, ClaimDate, CompleteDate, Notes);
END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `addban`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addban`(IN `rUserId` INT(10))
    READS SQL DATA
BEGIN
INSERT INTO `banned`(UserId, IsBanned) VALUES (rUserId, '0');
END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `banUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `banUser`(IN `rUserId` INT(10))
    READS SQL DATA
BEGIN
UPDATE `banned` SET IsBanned=1 WHERE UserId=rUserId;
END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `IsBanned`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `IsBanned`(IN `UserId` INT(10))
    READS SQL DATA
BEGIN

select i.IsBanned 
from banned i
where (i.UserId = UserId);

END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `addTag`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addTag`(IN `tag` VARCHAR(128))
    READS SQL DATA
BEGIN
INSERT INTO `tags`(tag) VALUES (tag);
END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `addUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addUser`(IN `FirstName` VARCHAR(128), IN `LastName` VARCHAR(128), IN `Email` VARCHAR(128), IN `Course` VARCHAR(128), IN `Password` VARCHAR(128))
    READS SQL DATA
BEGIN
INSERT INTO `Users`(FirstName, LastName, Email, Course, Password) VALUES (FirstName, Lastname, Email, Course, Password);
END$$

-- --------------------------------------------------------


DROP PROCEDURE IF EXISTS `flagTask`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `flagTask`(IN `TaskId` INT(10), IN `IsFlagged` TINYINT(1))
    READS SQL DATA
BEGIN
INSERT INTO `flag`(TaskId, IsFlagged) VALUES (TaskId, '1');
END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `getUser`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getUser`( IN `UserId` VARCHAR(128), IN `Email` VARCHAR(128))
    READS SQL DATA
BEGIN


	if UserId='' then set UserId=null;end if;
	if Email='' then set Email=null;end if;
	
	select u.UserId, u.Email, u.`FirstName`, u.`LastName`, u.`Course`, u.Password, u.Reputation  
        from Users u  
        where   (UserId is null or u.UserId = UserId)
            and (Email is null or (LOWER(u.Email) = LOWER(Email)));

END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `getTask`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getTask`( IN `TaskId` VARCHAR(128))
    READS SQL DATA
BEGIN


	if TaskId='20' then set TaskId=null;end if;
	
	
	select t.TaskId, t.Title, t.TaskType, t.Description, t.Words, t.Pages, t.FileFormat, t.FilePath, t.ClaimDate, t.CompleteDate ,t.Notes  
        from tasks t  
        where   (TaskId is null or t.TaskId = TaskId);

END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `getTags`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getTags`( IN `TaskId` VARCHAR(128))
    READS SQL DATA
BEGIN


	if TaskId='' then set TaskId=null;end if;
	
	
	select Tag 
        from tags 
        where TagId IN 
			(select TagId
				from TaskTags t
					where t.TaskId is null or t.TaskId = TaskId);

END$$

-- --------------------------------------------------------


DROP PROCEDURE IF EXISTS `getAllTasks`$$
CREATE DEFINER = `root`@`localhost` PROCEDURE `getAllTasks` ()
	READS SQL DATA
BEGIN

		select * from Tasks;
		
END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `ownsTask`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ownsTask`( IN `UserId` INT(10), IN `TaskId` INT(10))
    READS SQL DATA
BEGIN

INSERT INTO `Owned`(UserId, TaskId) VALUES (UserId, TaskId);

END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `claimedTask`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `claimedTask`( IN `UserId` INT(10), IN `TaskId` INT(10))
    READS SQL DATA
BEGIN

INSERT INTO `Claimed`(UserId, TaskId) VALUES (UserId, TaskId);

END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `claimTask`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `claimTask`(IN `rTaskId` INT(10))
    READS SQL DATA
BEGIN

UPDATE `StatusTable` SET Status=1 WHERE TaskId=rTaskId;

END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `CancelTask`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CancelTask`(IN `rTaskId` INT(10))
    READS SQL DATA
BEGIN

UPDATE `StatusTable` SET Status=3 WHERE TaskId=rTaskId;

END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `deleteTask`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteTask`(IN `rTaskId` INT(10))
    READS SQL DATA
BEGIN

DELETE FROM `tasks` WHERE TaskId = rTaskId;

END$$

-- --------------------------------------------------------


DROP PROCEDURE IF EXISTS `getTaskStatus`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getTaskStatus`(IN `TaskId` INT(10))
    READS SQL DATA
BEGIN

		select s.Status 
		from StatusTable s
		where (s.TaskId = TaskId);

END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `getFile`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getFile`(IN `FileId` VARCHAR(128), IN `FileName` VARCHAR(300))
    READS SQL DATA
BEGIN
	if FileId='' then set FileId=null;end if;
	if FileName='' then set FileName=null;end if;
	
	select u.fileId, u.fileName, u.fileType, u.fileSize, u.content  
        from upload u  
        where   (FileId is null or u.fileId = FileId)
            and (FileName is null or (LOWER(u.fileName) = LOWER(FileName)));

		
END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `addFile`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addFile`(IN `fileName` VARCHAR(300), IN `fileType` VARCHAR(300), IN `fileSize` INT, IN `content` MEDIUMBLOB)
    READS SQL DATA
BEGIN
INSERT INTO `Upload`(fileName, fileType, fileSize, content) VALUES (fileName, fileType, fileSize, content);
END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `addReview`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `addReview`(IN `rNotes` VARCHAR(128), IN `rTaskId` INT(10))
    READS SQL DATA
BEGIN
	
UPDATE `Tasks`
SET Notes = rNotes
WHERE TaskId = rTaskId;

		
END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `updateStatus`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateStatus`(IN `sTaskId` INT(10), IN `newStatus` INT(10))
    READS SQL DATA
BEGIN
	
UPDATE `StatusTable`
SET Status = newStatus
WHERE TaskId = sTaskId;

		
END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `getTaskClaimant`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getTaskClaimant`(IN `TaskId` INT(10))
    READS SQL DATA
BEGIN
SELECT UserId 
From claimed c 
WHERE (c.TaskId=TaskId);
END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `getOwner`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getOwner`(IN `TaskId` INT(10))
    READS SQL DATA
BEGIN
SELECT UserId 
From Owned o 
WHERE (o.TaskId=TaskId);
END$$

DELIMITER ;
-- --------------------------------------------------------
-- --------------------------------------------------------
--
-- Table Creation
--

--
-- Table Structure for table `Users`
--

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
-- --------------------------------------------------------

--
-- Table structure for table `Tasks`
--

CREATE TABLE IF NOT EXISTS `Tasks` (
`TaskId` int(10) unsigned NOT NULL AUTO_INCREMENT,
`Title` varchar(128) NOT NULL,
`TaskType` varchar(128) NOT NULL,
`TaskField` varchar(128) NOT NULL,
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

--
-- Table structure for table `Owned`
--

CREATE TABLE IF NOT EXISTS `Owned` (
`Numbered` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`UserId` int(10) unsigned NOT NULL,
`TaskId` int(10) unsigned NOT NULL ,
PRIMARY KEY (`Numbered`),
CONSTRAINT FOREIGN KEY (`UserId`) REFERENCES `Users`(`UserId`)ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY (`TaskId`) REFERENCES `Tasks`(`TaskId`) ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Table structure for table `Claimed`
--

CREATE TABLE IF NOT EXISTS `Claimed` (
`Numbered` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`UserId` int(10) unsigned NOT NULL,
`TaskId` int(10) unsigned NOT NULL ,
PRIMARY KEY (`Numbered`),
CONSTRAINT FOREIGN KEY (`UserId`) REFERENCES `Users`(`UserId`)ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY (`TaskId`) REFERENCES `Tasks`(`TaskId`) ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Table structure for table `Flag`
--

CREATE TABLE IF NOT EXISTS `Flag` (
`Numbered` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`TaskId` int(10) unsigned NOT NULL,
`IsFlagged` boolean NOT NULL DEFAULT 0,
PRIMARY KEY (`Numbered`),
CONSTRAINT FOREIGN KEY (`TaskId`) REFERENCES `Tasks`(`TaskId`) ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Table structure for table `Banned`
--

CREATE TABLE IF NOT EXISTS `Banned` (
`Numbered` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`UserId` int(10) unsigned NOT NULL,
`IsBanned` boolean NOT NULL DEFAULT 0,
PRIMARY KEY (`Numbered`),
CONSTRAINT FOREIGN KEY (`UserId`) REFERENCES `Users`(`UserId`) ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Table structure for table `Tags`
--

CREATE TABLE IF NOT EXISTS `Tags` (
`TagId` int(10) unsigned NOT NULL AUTO_INCREMENT,
`Tag` varchar(128) NOT NULL,
PRIMARY KEY (`TagId`)
);

--
-- Table structure for table `TaskTags`
--

CREATE TABLE IF NOT EXISTS `TaskTags` (
`Numbered` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`TaskId` int(10) unsigned NOT NULL,
`TagId` int(10) unsigned NOT NULL,
PRIMARY KEY (`Numbered`),
CONSTRAINT FOREIGN KEY (`TaskId`) REFERENCES `Tasks`(`TaskId`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY (`TagId`) REFERENCES `Tags`(`TagId`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- --------------------------------------------------------

--
-- Table structure for table `StatusTable`
--

CREATE TABLE IF NOT EXISTS `StatusTable` (
`Numbered` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`TaskId` int(10) unsigned NOT NULL,
`Status` int(1) unsigned NOT NULL DEFAULT 0,
PRIMARY KEY (`Numbered`),
CONSTRAINT FOREIGN KEY (`TaskId`) REFERENCES `Tasks`(`TaskId`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- --------------------------------------------------------

--
-- Table structure for table `Upload`
--

CREATE TABLE IF NOT EXISTS `upload` (
`fileId` INT NOT NULL AUTO_INCREMENT,
`fileName` VARCHAR(128) NOT NULL,
`fileType` VARCHAR(30) NOT NULL,
`fileSize` INT NOT NULL,
`content` MEDIUMBLOB NOT NULL,
PRIMARY KEY(fileId)
);

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
