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


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
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
  `CampusId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_bin NOT NULL,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`CampusId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
  `CourseId` int(11) NOT NULL AUTO_INCREMENT,
  `MajorId` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_bin NOT NULL,
  `Number` varchar(6) COLLATE utf8_bin NOT NULL,
  `Credits` int(11) NOT NULL,
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`CourseId`),
  KEY `MajorId` (`MajorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `cycle`
--

DROP TABLE IF EXISTS `cycle`;
CREATE TABLE IF NOT EXISTS `cycle` (
  `CycleId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE utf8_bin NOT NULL,
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`CycleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `DepartmentId` int(11) NOT NULL AUTO_INCREMENT,
  `SchoolId` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_bin NOT NULL,
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`DepartmentId`),
  KEY `SchoolId` (`SchoolId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `evaluationemail`
--

DROP TABLE IF EXISTS `evaluationemail`;
CREATE TABLE IF NOT EXISTS `evaluationemail` (
  `EvaluationEmailId` int(11) DEFAULT NULL,
  `SemesterId` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Quarter` varchar(25) COLLATE utf8_bin NOT NULL,
  `IsEnabled` bit(1) NOT NULL DEFAULT b'1',
  `AvailableForInstructors` bit(1) NOT NULL DEFAULT b'0',
  `Description` varchar(255) COLLATE utf8_bin NOT NULL,
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `SemesterId` (`SemesterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

DROP TABLE IF EXISTS `instructor`;
CREATE TABLE IF NOT EXISTS `instructor` (
  `InstructorId` int(11) NOT NULL AUTO_INCREMENT,
  `UniversityId` varchar(9) COLLATE utf8_bin NOT NULL,
  `FirstName` varchar(255) COLLATE utf8_bin NOT NULL,
  `LastName` varchar(255) COLLATE utf8_bin NOT NULL,
  `Email` varchar(255) COLLATE utf8_bin NOT NULL,
  `PhoneExtension` varchar(6) COLLATE utf8_bin NOT NULL,
  `Title` varchar(3) COLLATE utf8_bin NOT NULL,
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`InstructorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `instructorevaluationemail`
--

DROP TABLE IF EXISTS `instructorevaluationemail`;
CREATE TABLE IF NOT EXISTS `instructorevaluationemail` (
  `InstructorEvaluationEmailId` int(11) NOT NULL AUTO_INCREMENT,
  `EvaluationEmailId` int(11) NOT NULL,
  `InstructorId` int(11) NOT NULL,
  `EvaluationCode` varchar(25) COLLATE utf8_bin NOT NULL,
  `DateFilled` datetime DEFAULT NULL,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`InstructorEvaluationEmailId`),
  KEY `InstructorId` (`InstructorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

DROP TABLE IF EXISTS `major`;
CREATE TABLE IF NOT EXISTS `major` (
  `MajorId` int(11) NOT NULL AUTO_INCREMENT,
  `DepartmentId` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_bin NOT NULL,
  `Abbreviation` varchar(3) COLLATE utf8_bin NOT NULL,
  `RequiredCredits` int(11) NOT NULL,
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`MajorId`),
  KEY `DepartmentId` (`DepartmentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `offeredcourse`
--

DROP TABLE IF EXISTS `offeredcourse`;
CREATE TABLE IF NOT EXISTS `offeredcourse` (
  `OfferedCourseId` int(11) NOT NULL AUTO_INCREMENT,
  `CampusId` int(11) NOT NULL,
  `SemesterId` int(11) NOT NULL,
  `InstructorId` int(11) NOT NULL,
  `CourseId` int(11) NOT NULL,
  `CRN` int(11) NOT NULL,
  `Section` int(11) NOT NULL,
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`OfferedCourseId`),
  KEY `SemesterId` (`SemesterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school`;
CREATE TABLE IF NOT EXISTS `school` (
  `SchoolId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_bin NOT NULL,
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`SchoolId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `season`
--

DROP TABLE IF EXISTS `season`;
CREATE TABLE IF NOT EXISTS `season` (
  `SeasonId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `IsDeleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`SeasonId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
  `SemesterId` int(11) NOT NULL AUTO_INCREMENT,
  `Year` int(11) NOT NULL,
  `SeasonId` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `IsCurrent` bit(1) NOT NULL,
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`SemesterId`),
  KEY `SeasonId` (`SeasonId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `StudentId` int(11) NOT NULL AUTO_INCREMENT,
  `CycleId` int(11) NOT NULL,
  `UniversityId` varchar(9) COLLATE utf8_bin NOT NULL,
  `FirstName` varchar(255) COLLATE utf8_bin NOT NULL,
  `LastName` varchar(255) COLLATE utf8_bin NOT NULL,
  `FatherName` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `DOBMonth` int(11) DEFAULT NULL,
  `DOBYear` int(11) DEFAULT NULL,
  `Gender` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `PhoneNumber` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `Email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `Village` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `Caza` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `Mouhafaza` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `SchoolName` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `TwelveGrade` double DEFAULT NULL,
  `TenGrade` double DEFAULT NULL,
  `ElevenGrade` double DEFAULT NULL,
  `EnglishExamScore` double DEFAULT NULL,
  `IsDataEntryComplete` bit(1) DEFAULT NULL,
  `IsInitialVettingDone` bit(1) DEFAULT NULL,
  `VettingUpdated` bit(1) DEFAULT NULL,
  `AntiTerrorismCertification` bit(1) DEFAULT NULL,
  `StudentMOUSigned` bit(1) DEFAULT NULL,
  `HasLaptop` bit(1) DEFAULT NULL,
  `LaptopSerialNumber` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `ExpectedGraduation` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `SEESATScores` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `AdmissionSemester` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `AdmissionMajor` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `CurrentMajor` int(11) DEFAULT NULL,
  `TD` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `SIIDate` date DEFAULT NULL,
  `AcademicCoordinator` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `StudentMentor` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `CommunityDevelopmentProject` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `BankAccount` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `Branch` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `IDPCompleted` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `EligibilitySummer` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `SummersTakenCount` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `ReferredToCounselor` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `CSPCompleted` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `SchoolBackground` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `IsGraduated` bit(1) DEFAULT b'0',
  `OverallImpression` varchar(255) COLLATE utf8_bin NOT NULL,
  `Issues` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `Faculty` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `OldMajor` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `ConditionsChangeMajor` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `EnrolledTeachingDiploma` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `ParticipatedUSPSponsored` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `EnrolledDoubleMajor` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `EnrolledMajorMinor` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `CurrentEnrollmentStatus` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `Probation` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `ProbationRemovalDeadline` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `MeritStatus` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `Internship` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `InternshipHost` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `EngagedWorkshops` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `EngagedSoftSkills` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `EngagedEntrepreneurship` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `Duration` date DEFAULT NULL,
  `Certificate` tinyint(1) DEFAULT NULL,
  `LeadershipTraining` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `CivicEngagement` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `CommunityService` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `USPCompetition` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `StudentClub` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `NameOfClub` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `TookAcademicCourseLeadership` bit(1) DEFAULT NULL,
  `IsUpdatingIDP` bit(1) DEFAULT NULL,
  `EmploymentStatus` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `EmploymentLocation` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `StartOfEmployment` date DEFAULT NULL,
  `IsFullTimePosition` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `GraduateStudies` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `GraduateStudiesLocation` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `DateOfPhoneCall` date DEFAULT NULL,
  `PhoneCallMadeBy` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `RemarkableAchievements` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `EnrollmentConditions` varchar(255) COLLATE utf8_bin NOT NULL,
  `SupportProgram` varchar(255) COLLATE utf8_bin NOT NULL,
  `HousingTransportAllowance` varchar(255) COLLATE utf8_bin NOT NULL,
  `PreparatorySemester` varchar(255) COLLATE utf8_bin NOT NULL,
  `IsDeleted` bit(1) DEFAULT b'0',
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`StudentId`),
  KEY `CycleId` (`CycleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `studentcourseenrollment`
--

DROP TABLE IF EXISTS `studentcourseenrollment`;
CREATE TABLE IF NOT EXISTS `studentcourseenrollment` (
  `StudentCourseEnrollmentId` int(11) NOT NULL AUTO_INCREMENT,
  `StudentId` int(11) NOT NULL,
  `StudentSemesterEnrollmentId` int(11) NOT NULL,
  `OfferedCourseId` int(11) NOT NULL,
  `FinalGrade` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `IsDropped` bit(1) NOT NULL DEFAULT b'0',
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`StudentCourseEnrollmentId`),
  KEY `StudentId` (`StudentId`),
  KEY `StudentSemesterEnrollmentId` (`StudentSemesterEnrollmentId`),
  KEY `OfferedCourseId` (`OfferedCourseId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `studentcourseevaluation`
--

DROP TABLE IF EXISTS `studentcourseevaluation`;
CREATE TABLE IF NOT EXISTS `studentcourseevaluation` (
  `StudentCourseEvaluationId` int(11) NOT NULL AUTO_INCREMENT,
  `StudentCourseEnrollmentId` int(11) NOT NULL,
  `InstructorEvaluationEmailId` int(11) NOT NULL,
  `StudentId` int(11) NOT NULL,
  `NumberOfAbsences` int(11) DEFAULT NULL,
  `Grade` double DEFAULT NULL,
  `HomeWork` double DEFAULT NULL,
  `Participation` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `Effort` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `Attitude` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `Evaluation` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `InstructorNotes` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `UserNote` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `AdminNote` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`StudentCourseEvaluationId`),
  KEY `InstructorEvaluationEmailId` (`InstructorEvaluationEmailId`),
  KEY `StudentId` (`StudentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `studentplan`
--

DROP TABLE IF EXISTS `studentplan`;
CREATE TABLE IF NOT EXISTS `studentplan` (
  `StudentPlanId` int(11) NOT NULL AUTO_INCREMENT,
  `MajorId` int(11) NOT NULL,
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`StudentPlanId`),
  KEY `MajorId` (`MajorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `studentplanrow`
--

DROP TABLE IF EXISTS `studentplanrow`;
CREATE TABLE IF NOT EXISTS `studentplanrow` (
  `StudentPlanRowId` int(11) NOT NULL AUTO_INCREMENT,
  `StudentPlanId` int(11) NOT NULL,
  `CourseLetter` varchar(8) COLLATE utf8_bin NOT NULL,
  `Year` tinyint(1) NOT NULL,
  `Season` varchar(8) COLLATE utf8_bin NOT NULL,
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`StudentPlanRowId`),
  KEY `StudentPlanId` (`StudentPlanId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `studentsemesterenrollment`
--

DROP TABLE IF EXISTS `studentsemesterenrollment`;
CREATE TABLE IF NOT EXISTS `studentsemesterenrollment` (
  `StudentSemesterEnrollmentId` int(11) NOT NULL AUTO_INCREMENT,
  `StudentId` int(11) NOT NULL,
  `SemesterId` int(11) NOT NULL,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`StudentSemesterEnrollmentId`),
  KEY `StudentId` (`StudentId`),
  KEY `SemesterId` (`SemesterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) COLLATE utf8_bin NOT NULL,
  `Password` varchar(255) COLLATE utf8_bin NOT NULL,
  `Email` varchar(255) COLLATE utf8_bin NOT NULL,
  `FirstName` varchar(255) COLLATE utf8_bin NOT NULL,
  `LastName` varchar(255) COLLATE utf8_bin NOT NULL,
  `Type` int(11) NOT NULL,
  `IsDeleted` bit(1) NOT NULL DEFAULT b'0',
  `CreatedByUserId` int(11) NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserId`, `Username`, `Password`, `Email`, `FirstName`, `LastName`, `Type`, `IsDeleted`, `CreatedByUserId`, `DateAdded`) VALUES
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
  ADD CONSTRAINT `offeredcourse_ibfk_1` FOREIGN KEY (`SemesterId`) REFERENCES `semester` (`SemesterId`);

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
  ADD CONSTRAINT `studentcourseenrollment_ibfk_1` FOREIGN KEY (`StudentId`) REFERENCES `student` (`StudentId`),
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
