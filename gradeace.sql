SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


--
-- Database: `buynsell`
--

CREATE DATABASE IF NOT EXISTS `gradeace` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gradeace`;

--
-- Stored Procedures
--

DELIMITER $$

DROP PROCEDURE IF EXISTS `addTask`$$
CREATE DEFINER=`Dan`@`localhost` PROCEDURE `addTask`(IN `Title` VARCHAR(128), IN `TaskType` VARCHAR(128), IN `Description` VARCHAR(128), IN `Pages` INT(5), IN `Words` INT(10), IN `FileFormat` CHAR(128), IN `FilePath` VARCHAR(128), IN `ClaimDate` DATETIME, IN `CompleteDate` DATETIME, IN `Notes` VARCHAR(300))
    READS SQL DATA
BEGIN
INSERT INTO users(title, tasktype, description, pages, words, fileformat, filepath, claimdate, completedate, notes) VALUES (title, tasktype, description, pages, words, fileformat, filepath, claimdate, completedate, notes);
END$$

-- --------------------------------------------------------


DROP PROCEDURE IF EXISTS `banUser`$$
CREATE DEFINER=`Dan`@`localhost` PROCEDURE `banUser`(IN `userID` INT(10), IN `isBanned` TINYINT(1))
    READS SQL DATA
BEGIN
INSERT INTO users(userid, isbanned) VALUES (userid, '1');
END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `addTag`$$
CREATE DEFINER=`Dan`@`localhost` PROCEDURE `addTag`(IN `tag` VARCHAR(128))
    READS SQL DATA
BEGIN
INSERT INTO users(tag) VALUES (tag);
END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `addUser`$$
CREATE DEFINER=`Dan`@`localhost` PROCEDURE `addUser`(IN `firstname` VARCHAR(128), IN `lastname` VARCHAR(128), IN `email` VARCHAR(128), IN `course` VARCHAR(128), IN `password` VARCHAR(128))
    READS SQL DATA
BEGIN
INSERT INTO users(firstname, lastname, email, course, password) VALUES (firstname, lastname, email, course, password);
END$$

-- --------------------------------------------------------


DROP PROCEDURE IF EXISTS `flagTask`$$
CREATE DEFINER=`Dan`@`localhost` PROCEDURE `flagTask`(IN `taskid` INT(10), IN `isflagged` TINYINT(1))
    READS SQL DATA
BEGIN
INSERT INTO users(taskid, isflagged) VALUES (taskid, '1');
END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `getUser`$$
CREATE DEFINER=`Dan`@`localhost` PROCEDURE `getUser`( IN `UserId` VARCHAR(128), IN `Email` VARCHAR(128))
    READS SQL DATA
BEGIN


	if UserId='' then set UserId=null;end if;
	if Email='' then set Email=null;end if;
	
	select u.UserId, u.Email, u.`FirstName`, u.`LastName`, u.Password  
        from users u  
        where   (UserId is null or u.UserId = UserId)
            and (Email is null or (LOWER(u.Email) = LOWER(Email)));

END$$

-- --------------------------------------------------------

DROP PROCEDURE IF EXISTS `getTask`$$
CREATE DEFINER=`Dan`@`localhost` PROCEDURE `getTask`( IN `TaskId` VARCHAR(128))
    READS SQL DATA
BEGIN


	if TaskId='' then set TaskId=null;end if;
	
	
	select t.TaskId, t.Title, t.TaskType, t.Description, t.Words, t.Pages, t.FileFormat, t.FilePath, t.ClaimDate, t.CompleteDate ,t.Notes  
        from Tasks t  
        where   (TaskId is null or t.TaskId = TaskId);

END$$

DELIMITER ;


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
CONSTRAINT FOREIGN KEY (`UserId`) REFERENCES USERS(`UserId`)ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY (`TaskId`) REFERENCES TASKS(`TaskId`) ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Table structure for table `Flag`
--

CREATE TABLE IF NOT EXISTS `Flag` (
`Numbered` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`TaskId` int(10) unsigned NOT NULL,
`IsFlagged` boolean NOT NULL DEFAULT 0,
PRIMARY KEY (`Numbered`),
CONSTRAINT FOREIGN KEY (`TaskId`) REFERENCES TASKS(`TaskId`) ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Table structure for table `Banned`
--

CREATE TABLE IF NOT EXISTS `Banned` (
`Numbered` int(10) unsigned NOT NULL AUTO_INCREMENT, 
`UserId` int(10) unsigned NOT NULL,
`IsBanned` boolean NOT NULL DEFAULT 0,
PRIMARY KEY (`Numbered`),
CONSTRAINT FOREIGN KEY (`UserId`) REFERENCES Users(`UserId`) ON DELETE CASCADE ON UPDATE CASCADE
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
CONSTRAINT FOREIGN KEY (`TaskId`) REFERENCES TASKS(`TaskId`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY (`TagId`) REFERENCES TAGS(`TagId`) ON DELETE CASCADE ON UPDATE CASCADE
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
CONSTRAINT FOREIGN KEY (`TaskId`) REFERENCES TASKS(`TaskId`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- --------------------------------------------------------

--
-- Table structure for table `Upload`
--

CREATE TABLE upload (
id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(30) NOT NULL,
type VARCHAR(30) NOT NULL,
size INT NOT NULL,
content MEDIUMBLOB NOT NULL,
PRIMARY KEY(id)
);

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;