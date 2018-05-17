-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 15, 2018 at 05:12 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usp`
--

-- --------------------------------------------------------

--
-- Table structure for table `campus`
--

DROP TABLE IF EXISTS `campus`;
CREATE TABLE IF NOT EXISTS `campus` (
  `CampusId`  INT(11)                       NOT NULL AUTO_INCREMENT,
  `Name`      VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `IsDeleted` BIT(1)                        NOT NULL DEFAULT b'0',
  PRIMARY KEY (`CampusId`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

--
-- Dumping data for table `campus`
--

INSERT INTO `campus` (`CampusId`, `Name`, `IsDeleted`) VALUES
  (1, 'Beirut', b'0'),
  (2, 'Byblos', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `CourseId`        INT(11)                       NOT NULL AUTO_INCREMENT,
  `MajorId`         INT(11)                       NOT NULL,
  `Name`            VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `Number`          VARCHAR(6) COLLATE utf8_bin   NOT NULL,
  `Credits`         INT(11)                       NOT NULL,
  `CreatedByUserId` INT(11)                       NOT NULL,
  `DateAdded`       TIMESTAMP                     NULL     DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted`       BIT(1)                                 DEFAULT b'0',
  PRIMARY KEY (`CourseId`),
  KEY `MajorId` (`MajorId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `cycle`
--

DROP TABLE IF EXISTS `cycle`;
CREATE TABLE IF NOT EXISTS `cycle` (
  `CycleId`         INT(11)                      NOT NULL AUTO_INCREMENT,
  `Name`            VARCHAR(50) COLLATE utf8_bin NOT NULL,
  `CreatedByUserId` INT(11)                      NOT NULL,
  `DateAdded`       TIMESTAMP                    NULL     DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted`       BIT(1)                       NOT NULL DEFAULT b'0',
  PRIMARY KEY (`CycleId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `DepartmentId`    INT(11)                       NOT NULL AUTO_INCREMENT,
  `SchoolId`        INT(11)                       NOT NULL,
  `Name`            VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `CreatedByUserId` INT(11)                       NOT NULL,
  `DateAdded`       TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted`       BIT(1)                        NOT NULL DEFAULT b'0',
  PRIMARY KEY (`DepartmentId`),
  KEY `SchoolId` (`SchoolId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `evaluationemail`
--

DROP TABLE IF EXISTS `evaluationemail`;
CREATE TABLE IF NOT EXISTS `evaluationemail` (
  `EvaluationEmailId`       INT(11)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      DEFAULT NULL,
  `SemesterId`              INT(11)                       NOT NULL,
  `Date`                    DATE    NOT NULL,
  `Quarter`                 VARCHAR(25) COLLATE utf8_bin NOT NULL,
  `IsEnabled`               BIT(1)                       NOT NULL                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     DEFAULT b'1',
  `AvailableForInstructors` BIT(1)                       NOT NULL                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     DEFAULT b'0',
  `Description`             VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `CreatedByUserId`         INT(11)                       NOT NULL,
  `DateAdded`               TIMESTAMP                     NOT NULL                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    DEFAULT CURRENT_TIMESTAMP,
  KEY `SemesterId` (`SemesterId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

DROP TABLE IF EXISTS `instructor`;
CREATE TABLE IF NOT EXISTS `instructor` (
  `InstructorId`    INT(11)                       NOT NULL AUTO_INCREMENT,
  `UniversityId` VARCHAR(9) COLLATE utf8_bin NOT NULL,
  `FirstName`    VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `LastName`     VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `Email`        VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `PhoneExtension` VARCHAR(6) COLLATE utf8_bin   NOT NULL,
  `Title`          VARCHAR(3) COLLATE utf8_bin   NOT NULL,
  `CreatedByUserId` INT(11)                       NOT NULL,
  `DateAdded`       TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted`       BIT(1)                        NOT NULL DEFAULT b'0',
  PRIMARY KEY (`InstructorId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `instructorevaluationemail`
--

DROP TABLE IF EXISTS `instructorevaluationemail`;
CREATE TABLE IF NOT EXISTS `instructorevaluationemail` (
  `InstructorEvaluationEmailId` INT(11)                      NOT NULL AUTO_INCREMENT,
  `EvaluationEmailId`           INT(11) NOT NULL,
  `InstructorId`                INT(11) NOT NULL,
  `EvaluationCode`              VARCHAR(25) COLLATE utf8_bin NOT NULL,
  `DateFilled`                  DATETIME                              DEFAULT NULL,
  `IsDeleted`                   BIT(1)                       NOT NULL DEFAULT b'0',
  PRIMARY KEY (`InstructorEvaluationEmailId`),
  KEY `InstructorId` (`InstructorId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

DROP TABLE IF EXISTS `major`;
CREATE TABLE IF NOT EXISTS `major` (
  `MajorId`         INT(11)                       NOT NULL AUTO_INCREMENT,
  `DepartmentId` INT(11) NOT NULL,
  `Name`         VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `Abbreviation` VARCHAR(3) COLLATE utf8_bin   NOT NULL,
  `RequiredCredits` INT(11)                       NOT NULL,
  `CreatedByUserId` INT(11)                       NOT NULL,
  `DateAdded`       TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted`       BIT(1)                        NOT NULL DEFAULT b'0',
  PRIMARY KEY (`MajorId`),
  KEY `DepartmentId` (`DepartmentId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `offeredcourse`
--

DROP TABLE IF EXISTS `offeredcourse`;
CREATE TABLE IF NOT EXISTS `offeredcourse` (
  `OfferedCourseId` INT(11)   NOT NULL AUTO_INCREMENT,
  `CampusId`        INT(11) NOT NULL,
  `SemesterId`      INT(11) NOT NULL,
  `InstructorId`    INT(11) NOT NULL,
  `CourseId`        INT(11) NOT NULL,
  `CRN`             INT(11) NOT NULL,
  `Section`         INT(11) NOT NULL,
  `CreatedByUserId` INT(11) NOT NULL,
  `DateAdded`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted`       BIT(1)    NOT NULL DEFAULT b'0',
  PRIMARY KEY (`OfferedCourseId`),
  KEY `SemesterId` (`SemesterId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school`;
CREATE TABLE IF NOT EXISTS `school` (
  `SchoolId`        INT(11)                       NOT NULL AUTO_INCREMENT,
  `Name`     VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `CreatedByUserId` INT(11)                       NOT NULL,
  `DateAdded`       TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted`       BIT(1)                        NOT NULL DEFAULT b'0',
  PRIMARY KEY (`SchoolId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `season`
--

DROP TABLE IF EXISTS `season`;
CREATE TABLE IF NOT EXISTS `season` (
  `SeasonId`  INT(11) NOT NULL              AUTO_INCREMENT,
  `Name`     VARCHAR(255) COLLATE utf8_bin DEFAULT NULL,
  `IsDeleted` BIT(1)                        DEFAULT b'0',
  PRIMARY KEY (`SeasonId`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 4
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

--
-- Dumping data for table `season`
--

INSERT INTO `season` (`SeasonId`, `Name`, `IsDeleted`) VALUES
  (1, 'Spring', b'0'),
  (2, 'Fall', b'0'),
  (3, 'Summer', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

DROP TABLE IF EXISTS `semester`;
CREATE TABLE IF NOT EXISTS `semester` (
  `SemesterId`      INT(11)   NOT NULL AUTO_INCREMENT,
  `Year`       INT(11) NOT NULL,
  `SeasonId`   INT(11) NOT NULL,
  `StartDate`  DATE    NOT NULL,
  `EndDate`    DATE    NOT NULL,
  `IsCurrent`  BIT(1)  NOT NULL,
  `CreatedByUserId` INT(11) NOT NULL,
  `DateAdded`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted`       BIT(1)    NOT NULL DEFAULT b'0',
  PRIMARY KEY (`SemesterId`),
  KEY `SeasonId` (`SeasonId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `StudentId`                    INT(11)                       NOT NULL AUTO_INCREMENT,
  `CycleId`   INT(11) NOT NULL,
  `UniversityId` VARCHAR(9) COLLATE utf8_bin NOT NULL,
  `FirstName`    VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `LastName`     VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `FatherName`   VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `DOBMonth`     INT(11)                                DEFAULT NULL,
  `DOBYear`      INT(11)                                DEFAULT NULL,
  `Gender`       VARCHAR(1) COLLATE utf8_bin            DEFAULT NULL,
  `PhoneNumber`  VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `Email`        VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `Village`      VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `Caza`         VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `Mouhafaza`    VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `SchoolName`   VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `TwelveGrade`  DOUBLE                                 DEFAULT NULL,
  `TenGrade`     DOUBLE                                 DEFAULT NULL,
  `ElevenGrade`  DOUBLE                                 DEFAULT NULL,
  `EnglishExamScore` DOUBLE                                 DEFAULT NULL,
  `IsDataEntryComplete` BIT(1)                                 DEFAULT NULL,
  `IsInitialVettingDone` BIT(1)                                 DEFAULT NULL,
  `VettingUpdated`       BIT(1)                                 DEFAULT NULL,
  `AntiTerrorismCertification` BIT(1)                                 DEFAULT NULL,
  `StudentMOUSigned`           BIT(1)                                 DEFAULT NULL,
  `HasLaptop`                  BIT(1)                                 DEFAULT NULL,
  `LaptopSerialNumber`         VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `ExpectedGraduation`         VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `SEESATScores`               VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `AdmissionSemester`          VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `AdmissionMajor`             VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `CurrentMajor`               INT(11)                                DEFAULT NULL,
  `TD`                         BIT                                    DEFAULT NULL,
  `SIIDate`                    DATE                                   DEFAULT NULL,
  `AcademicCoordinator`        VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `StudentMentor`              VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `CommunityDevelopmentProject` VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `BankAccount`                 VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `Branch`                      VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `IDPCompleted`                BIT                                    DEFAULT NULL,
  `EligibilitySummer`           BIT                                    DEFAULT NULL,
  `SummersTakenCount`           VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `ReferredToCounselor`         BIT                                    DEFAULT NULL,
  `CSPCompleted`                BIT                                    DEFAULT NULL,
  `SchoolBackground`            VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `IsGraduated`                 BIT(1)                                 DEFAULT b'0',
  `OverallImpression`           VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `Issues`                      VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `Faculty`                     VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `OldMajor`                    VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `ConditionsChangeMajor`       VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `EnrolledTeachingDiploma`     VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `ParticipatedUSPSponsored`    VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `EnrolledDoubleMajor`         BIT                                    DEFAULT NULL,
  `EnrolledMajorMinor`          BIT                                    DEFAULT NULL,
  `CurrentEnrollmentStatus`     VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `Probation`                   BIT                                    DEFAULT NULL,
  `ProbationRemovalDeadline`    VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `MeritStatus`                 VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `Internship`                  VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `InternshipHost`              VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `EngagedWorkshops`            VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `EngagedSoftSkills`           VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `EngagedEntrepreneurship`     VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `Duration`                    DATE                                   DEFAULT NULL,
  `Certificate`                 BIT                                    DEFAULT NULL,
  `LeadershipTraining`          VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `CivicEngagement`             VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `CommunityService`            VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `USPCompetition`              VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `StudentClub`                 VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `NameOfClub`                  VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `TookAcademicCourseLeadership` BIT(1)                                 DEFAULT NULL,
  `IsUpdatingIDP`                BIT(1)                                 DEFAULT NULL,
  `EmploymentStatus`             VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `EmploymentLocation`           VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `StartOfEmployment`            DATE                                   DEFAULT NULL,
  `IsFullTimePosition`           BIT                                    DEFAULT NULL,
  `GraduateStudies`              VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `GraduateStudiesLocation`      VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `DateOfPhoneCall`              DATE                                   DEFAULT NULL,
  `PhoneCallMadeBy`              VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `RemarkableAchievements`       VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `EnrollmentConditions`         VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `SupportProgram`               VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `HousingTransportAllowance`    VARCHAR(255) COLLATE utf8_bin          DEFAULT NULL,
  `PreparatorySemester`          BIT                                    DEFAULT NULL,
  `IsDeleted`                    BIT(1)                                 DEFAULT b'0',
  `CreatedByUserId`              INT(11)                       NOT NULL,
  `DateAdded`                    TIMESTAMP                     NULL     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`StudentId`),
  KEY `CycleId` (`CycleId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `studentcourseenrollment`
--

DROP TABLE IF EXISTS `studentcourseenrollment`;
CREATE TABLE IF NOT EXISTS `studentcourseenrollment` (
  `StudentCourseEnrollmentId`   INT(11)   NOT NULL              AUTO_INCREMENT,
  `StudentSemesterEnrollmentId` INT(11) NOT NULL,
  `OfferedCourseId`             INT(11) NOT NULL,
  `FinalGrade`                  VARCHAR(255) COLLATE utf8_bin DEFAULT NULL,
  `IsDropped`                   BIT(1)  NOT NULL              DEFAULT b'0',
  `IsDeleted`                   BIT(1)  NOT NULL              DEFAULT b'0',
  `CreatedByUserId`             INT(11) NOT NULL,
  `DateAdded`                   TIMESTAMP NOT NULL              DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`StudentCourseEnrollmentId`),
  KEY `StudentId` (`StudentId`),
  KEY `StudentSemesterEnrollmentId` (`StudentSemesterEnrollmentId`),
  KEY `OfferedCourseId` (`OfferedCourseId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `studentcourseevaluation`
--

DROP TABLE IF EXISTS `studentcourseevaluation`;
CREATE TABLE IF NOT EXISTS `studentcourseevaluation` (
  `StudentCourseEvaluationId`   INT(11)   NOT NULL              AUTO_INCREMENT,
  `StudentCourseEnrollmentId` INT(11) NOT NULL,
  `InstructorEvaluationEmailId` INT(11) NOT NULL,
  `StudentId`                   INT(11) NOT NULL,
  `NumberOfAbsences`            INT(11)                       DEFAULT NULL,
  `Grade`                       DOUBLE                        DEFAULT NULL,
  `HomeWork`                    DOUBLE                        DEFAULT NULL,
  `Participation`               VARCHAR(20) COLLATE utf8_bin  DEFAULT NULL,
  `Effort`                      VARCHAR(20) COLLATE utf8_bin  DEFAULT NULL,
  `Attitude`                    VARCHAR(20) COLLATE utf8_bin  DEFAULT NULL,
  `Evaluation`                  VARCHAR(20) COLLATE utf8_bin  DEFAULT NULL,
  `InstructorNotes`             VARCHAR(255) COLLATE utf8_bin DEFAULT NULL,
  `UserNote`                    VARCHAR(255) COLLATE utf8_bin DEFAULT NULL,
  `AdminNote`                   VARCHAR(255) COLLATE utf8_bin DEFAULT NULL,
  `IsDeleted`                   BIT(1)  NOT NULL              DEFAULT b'0',
  `DateAdded`                   TIMESTAMP NOT NULL              DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`StudentCourseEvaluationId`),
  KEY `InstructorEvaluationEmailId` (`InstructorEvaluationEmailId`),
  KEY `StudentId` (`StudentId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `studentplan`
--

DROP TABLE IF EXISTS `studentplan`;
CREATE TABLE IF NOT EXISTS `studentplan` (
  `StudentPlanId`   INT(11)   NOT NULL AUTO_INCREMENT,
  `MajorId`       INT(11) NOT NULL,
  `CreatedByUserId` INT(11) NOT NULL,
  `DateAdded`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted`       BIT(1)    NOT NULL DEFAULT b'0',
  PRIMARY KEY (`StudentPlanId`),
  KEY `MajorId` (`MajorId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `studentplanrow`
--

DROP TABLE IF EXISTS `studentplanrow`;
CREATE TABLE IF NOT EXISTS `studentplanrow` (
  `StudentPlanRowId` INT(11)                     NOT NULL AUTO_INCREMENT,
  `StudentPlanId`    INT(11) NOT NULL,
  `CourseLetter`     VARCHAR(8) COLLATE utf8_bin NOT NULL,
  `Year`             TINYINT(1)                  NOT NULL,
  `Season`           VARCHAR(8) COLLATE utf8_bin NOT NULL,
  `CreatedByUserId`  INT(11)                     NOT NULL,
  `DateAdded`        TIMESTAMP                   NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted`        BIT(1)                      NOT NULL DEFAULT b'0',
  PRIMARY KEY (`StudentPlanRowId`),
  KEY `StudentPlanId` (`StudentPlanId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `studentsemesterenrollment`
--

DROP TABLE IF EXISTS `studentsemesterenrollment`;
CREATE TABLE IF NOT EXISTS `studentsemesterenrollment` (
  `StudentSemesterEnrollmentId` INT(11)   NOT NULL AUTO_INCREMENT,
  `StudentId`                   INT(11) NOT NULL,
  `SemesterId`                  INT(11) NOT NULL,
  `IsDeleted`                   BIT(1)  NOT NULL DEFAULT b'0',
  `CreatedByUserId`             INT(11) NOT NULL,
  `DateAdded`                   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`StudentSemesterEnrollmentId`),
  KEY `StudentId` (`StudentId`),
  KEY `SemesterId` (`SemesterId`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `UserId`          INT(11)                       NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `Password` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `Email`    VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `FirstName` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `LastName`  VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `Type`      INT(11)                       NOT NULL,
  `IsDeleted` BIT(1)                        NOT NULL DEFAULT b'0',
  `CreatedByUserId` INT(11)                       NOT NULL,
  `DateAdded`       TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`UserId`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8
  COLLATE = utf8_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserId`, `Username`, `Password`, `Email`, `FirstName`, `LastName`, `Type`, `IsDeleted`, `CreatedByUserId`, `DateAdded`)
VALUES
  (1, 'admin', 'admin', 'admin@admin.com', 'Admin', 'Admin', 1, b'1', 0, '2018-05-15 17:04:57'),
  (2, 'user', 'user', 'user@user.com', 'User', 'User', 2, b'1', 0, '2018-05-15 17:06:17');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`MajorId`) REFERENCES `major` (`MajorId`);

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`SchoolId`) REFERENCES `school` (`SchoolId`);

--
-- Constraints for table `evaluationemail`
--
ALTER TABLE `evaluationemail`
  ADD CONSTRAINT `evaluationemail_ibfk_1` FOREIGN KEY (`SemesterId`) REFERENCES `semester` (`SemesterId`);

--
-- Constraints for table `instructorevaluationemail`
--
ALTER TABLE `instructorevaluationemail`
  ADD CONSTRAINT `instructorevaluationemail_ibfk_1` FOREIGN KEY (`InstructorId`) REFERENCES `instructor` (`InstructorId`);

--
-- Constraints for table `major`
--
ALTER TABLE `major`
  ADD CONSTRAINT `major_ibfk_1` FOREIGN KEY (`DepartmentId`) REFERENCES `department` (`DepartmentId`);

--
-- Constraints for table `offeredcourse`
--
ALTER TABLE `offeredcourse`
  ADD CONSTRAINT `offeredcourse_ibfk_1` FOREIGN KEY (`SemesterId`) REFERENCES `semester` (`SemesterId`),
  ADD CONSTRAINT `offeredcourse_ibfk_2` FOREIGN KEY (`CourseId`) REFERENCES `course` (`CourseId`),
  ADD CONSTRAINT `offeredcourse_ibfk_3` FOREIGN KEY (`InstructorId`) REFERENCES `instructor` (`InstructorId`);

--
-- Constraints for table `semester`
--
ALTER TABLE `semester`
  ADD CONSTRAINT `semester_ibfk_1` FOREIGN KEY (`SeasonId`) REFERENCES `season` (`SeasonId`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`CycleId`) REFERENCES `cycle` (`CycleId`);

--
-- Constraints for table `studentcourseenrollment`
--
ALTER TABLE `studentcourseenrollment`
  ADD CONSTRAINT `studentcourseenrollment_ibfk_2` FOREIGN KEY (`StudentSemesterEnrollmentId`) REFERENCES `studentsemesterenrollment` (`StudentSemesterEnrollmentId`),
  ADD CONSTRAINT `studentcourseenrollment_ibfk_3` FOREIGN KEY (`OfferedCourseId`) REFERENCES `offeredcourse` (`OfferedCourseId`);

--
-- Constraints for table `studentcourseevaluation`
--
ALTER TABLE `studentcourseevaluation`
  ADD CONSTRAINT `studentcourseevaluation_ibfk_1` FOREIGN KEY (`InstructorEvaluationEmailId`) REFERENCES `instructorevaluationemail` (`InstructorEvaluationEmailId`),
  ADD CONSTRAINT `studentcourseevaluation_ibfk_2` FOREIGN KEY (`StudentId`) REFERENCES `student` (`StudentId`);

--
-- Constraints for table `studentplan`
--
ALTER TABLE `studentplan`
  ADD CONSTRAINT `studentplan_ibfk_1` FOREIGN KEY (`MajorId`) REFERENCES `major` (`MajorId`);

--
-- Constraints for table `studentplanrow`
--
ALTER TABLE `studentplanrow`
  ADD CONSTRAINT `studentplanrow_ibfk_1` FOREIGN KEY (`StudentPlanId`) REFERENCES `studentplan` (`StudentPlanId`);

--
-- Constraints for table `studentsemesterenrollment`
--
ALTER TABLE `studentsemesterenrollment`
  ADD CONSTRAINT `studentsemesterenrollment_ibfk_1` FOREIGN KEY (`StudentId`) REFERENCES `student` (`StudentId`),
  ADD CONSTRAINT `studentsemesterenrollment_ibfk_2` FOREIGN KEY (`SemesterId`) REFERENCES `semester` (`SemesterId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
