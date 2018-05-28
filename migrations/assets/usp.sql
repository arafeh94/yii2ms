SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS studentsemesterenrollment;
DROP TABLE IF EXISTS studentplanrow;
DROP TABLE IF EXISTS studyplan;
DROP TABLE IF EXISTS studentplan;
DROP TABLE IF EXISTS studentcourseevaluation;
DROP TABLE IF EXISTS studentcourseenrollment;
DROP TABLE IF EXISTS student;
DROP TABLE IF EXISTS semester;
DROP TABLE IF EXISTS season;
DROP TABLE IF EXISTS school;
DROP TABLE IF EXISTS offeredcourse;
DROP TABLE IF EXISTS migration;
DROP TABLE IF EXISTS major;
DROP TABLE IF EXISTS instructorevaluationemail;
DROP TABLE IF EXISTS instructor;
DROP TABLE IF EXISTS evaluationemail;
DROP TABLE IF EXISTS department;
DROP TABLE IF EXISTS cycle;
DROP TABLE IF EXISTS course;
DROP TABLE IF EXISTS campus;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE campus
(
  CampusId  INT AUTO_INCREMENT
    PRIMARY KEY,
  Name      VARCHAR(255)     NOT NULL,
  IsDeleted BIT DEFAULT b'0' NOT NULL
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE TABLE course
(
  CourseId        INT AUTO_INCREMENT
    PRIMARY KEY,
  MajorId         INT                                 NOT NULL,
  Name            VARCHAR(255)                        NOT NULL,
  Number          VARCHAR(8)                          NOT NULL,
  Credits         INT                                 NOT NULL,
  CreatedByUserId INT                                 NOT NULL,
  DateAdded       TIMESTAMP DEFAULT CURRENT_TIMESTAMP NULL,
  IsDeleted       BIT DEFAULT b'0'                    NULL
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE INDEX MajorId
  ON course (MajorId);

CREATE TABLE cycle
(
  CycleId         INT AUTO_INCREMENT
    PRIMARY KEY,
  Name            VARCHAR(50)                         NOT NULL,
  CreatedByUserId INT                                 NOT NULL,
  DateAdded       TIMESTAMP DEFAULT CURRENT_TIMESTAMP NULL,
  IsDeleted       BIT DEFAULT b'0'                    NOT NULL
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE TABLE department
(
  DepartmentId    INT AUTO_INCREMENT
    PRIMARY KEY,
  SchoolId        INT                                 NOT NULL,
  Name            VARCHAR(255)                        NOT NULL,
  CreatedByUserId INT                                 NOT NULL,
  DateAdded       TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  IsDeleted       BIT DEFAULT b'0'                    NOT NULL
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE INDEX SchoolId
  ON department (SchoolId);

CREATE TABLE evaluationemail
(
  EvaluationEmailId       INT AUTO_INCREMENT
    PRIMARY KEY,
  SemesterId              INT                                 NOT NULL,
  Date                    DATE                                NOT NULL,
  Quarter                 VARCHAR(25)                         NOT NULL,
  IsEnabled               BIT DEFAULT b'1'                    NOT NULL,
  AvailableForInstructors BIT DEFAULT b'0'                    NOT NULL,
  Description             VARCHAR(255)                        NOT NULL,
  CreatedByUserId         INT                                 NOT NULL,
  DateAdded               TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  IsDeleted               BIT DEFAULT b'0'                    NULL
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE INDEX SemesterId
  ON evaluationemail (SemesterId);

CREATE TABLE instructor
(
  InstructorId    INT AUTO_INCREMENT
    PRIMARY KEY,
  UniversityId    VARCHAR(9)                          NOT NULL,
  FirstName       VARCHAR(255)                        NOT NULL,
  LastName        VARCHAR(255)                        NOT NULL,
  Email           VARCHAR(255)                        NOT NULL,
  PhoneExtension  VARCHAR(6)                          NOT NULL,
  Title           VARCHAR(3)                          NOT NULL,
  CreatedByUserId INT                                 NOT NULL,
  DateAdded       TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  IsDeleted       BIT DEFAULT b'0'                    NOT NULL
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE TABLE instructorevaluationemail
(
  InstructorEvaluationEmailId INT AUTO_INCREMENT
    PRIMARY KEY,
  EvaluationEmailId           INT              NOT NULL,
  InstructorId                INT              NOT NULL,
  EvaluationCode              VARCHAR(25)      NOT NULL,
  DateFilled                  DATETIME         NULL,
  IsDeleted                   BIT DEFAULT b'0' NOT NULL,
  CONSTRAINT instructorevaluationemail_evaluationemail_EvaluationEmailId_fk
  FOREIGN KEY (EvaluationEmailId) REFERENCES evaluationemail (EvaluationEmailId),
  CONSTRAINT instructorevaluationemail_ibfk_1
  FOREIGN KEY (InstructorId) REFERENCES instructor (InstructorId)
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE INDEX instructorevaluationemail_evaluationemail_EvaluationEmailId_fk
  ON instructorevaluationemail (EvaluationEmailId);

CREATE INDEX InstructorId
  ON instructorevaluationemail (InstructorId);

CREATE TABLE major
(
  MajorId         INT AUTO_INCREMENT
    PRIMARY KEY,
  DepartmentId    INT                                 NOT NULL,
  Name            VARCHAR(255)                        NOT NULL,
  Abbreviation    VARCHAR(3)                          NOT NULL,
  RequiredCredits INT                                 NOT NULL,
  CreatedByUserId INT                                 NOT NULL,
  DateAdded       TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  IsDeleted       BIT DEFAULT b'0'                    NOT NULL,
  CONSTRAINT major_ibfk_1
  FOREIGN KEY (DepartmentId) REFERENCES department (DepartmentId)
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE INDEX DepartmentId
  ON major (DepartmentId);

ALTER TABLE course
  ADD CONSTRAINT course_ibfk_1
FOREIGN KEY (MajorId) REFERENCES major (MajorId);

CREATE TABLE migration
(
  version    VARCHAR(180) NOT NULL
    PRIMARY KEY,
  apply_time INT          NULL
)
  ENGINE = MyISAM;

CREATE TABLE offeredcourse
(
  OfferedCourseId INT AUTO_INCREMENT
    PRIMARY KEY,
  CampusId        INT                                 NOT NULL,
  SemesterId      INT                                 NOT NULL,
  InstructorId    INT                                 NOT NULL,
  CourseId        INT                                 NOT NULL,
  CRN             INT                                 NOT NULL,
  Section         INT                                 NOT NULL,
  CreatedByUserId INT                                 NOT NULL,
  DateAdded       TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  IsDeleted       BIT DEFAULT b'0'                    NOT NULL,
  CONSTRAINT offeredcourse_ibfk_3
  FOREIGN KEY (InstructorId) REFERENCES instructor (InstructorId),
  CONSTRAINT offeredcourse_ibfk_2
  FOREIGN KEY (CourseId) REFERENCES course (CourseId)
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE INDEX SemesterId
  ON offeredcourse (SemesterId);

CREATE INDEX offeredcourse_ibfk_3
  ON offeredcourse (InstructorId);

CREATE INDEX offeredcourse_ibfk_2
  ON offeredcourse (CourseId);

CREATE TABLE school
(
  SchoolId        INT AUTO_INCREMENT
    PRIMARY KEY,
  Name            VARCHAR(255)                        NOT NULL,
  CreatedByUserId INT                                 NOT NULL,
  DateAdded       TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  IsDeleted       BIT DEFAULT b'0'                    NOT NULL
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

ALTER TABLE department
  ADD CONSTRAINT department_ibfk_1
FOREIGN KEY (SchoolId) REFERENCES school (SchoolId);

CREATE TABLE season
(
  SeasonId  INT AUTO_INCREMENT
    PRIMARY KEY,
  Name      VARCHAR(255)     NULL,
  IsDeleted BIT DEFAULT b'0' NULL
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE TABLE semester
(
  SemesterId      INT AUTO_INCREMENT
    PRIMARY KEY,
  Year            INT                                 NOT NULL,
  SeasonId        INT                                 NOT NULL,
  StartDate       DATE                                NOT NULL,
  EndDate         DATE                                NOT NULL,
  IsCurrent       BIT                                 NOT NULL,
  CreatedByUserId INT                                 NOT NULL,
  DateAdded       TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  IsDeleted       BIT DEFAULT b'0'                    NOT NULL,
  CONSTRAINT semester_ibfk_1
  FOREIGN KEY (SeasonId) REFERENCES season (SeasonId)
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE INDEX SeasonId
  ON semester (SeasonId);

ALTER TABLE evaluationemail
  ADD CONSTRAINT evaluationemail_ibfk_1
FOREIGN KEY (SemesterId) REFERENCES semester (SemesterId);

ALTER TABLE offeredcourse
  ADD CONSTRAINT offeredcourse_ibfk_1
FOREIGN KEY (SemesterId) REFERENCES semester (SemesterId);

CREATE TABLE student
(
  StudentId                    INT AUTO_INCREMENT
    PRIMARY KEY,
  CycleId                      INT                                 NOT NULL,
  UniversityId                 VARCHAR(9)                          NOT NULL,
  FirstName                    VARCHAR(255)                        NOT NULL,
  LastName                     VARCHAR(255)                        NOT NULL,
  FatherName                   VARCHAR(255)                        NULL,
  DOBMonth                     INT                                 NULL,
  DOBYear                      INT                                 NULL,
  Gender                       VARCHAR(1)                          NULL,
  PhoneNumber                  VARCHAR(255)                        NULL,
  Email                        VARCHAR(255)                        NULL,
  Village                      VARCHAR(255)                        NULL,
  Caza                         VARCHAR(255)                        NULL,
  Mouhafaza                    VARCHAR(255)                        NULL,
  SchoolName                   VARCHAR(255)                        NULL,
  TwelveGrade                  DOUBLE                              NULL,
  TenGrade                     DOUBLE                              NULL,
  ElevenGrade                  DOUBLE                              NULL,
  EnglishExamScore             DOUBLE                              NULL,
  IsDataEntryComplete          BIT                                 NULL,
  IsInitialVettingDone         BIT                                 NULL,
  VettingUpdated               BIT                                 NULL,
  AntiTerrorismCertification   BIT                                 NULL,
  StudentMOUSigned             BIT                                 NULL,
  HasLaptop                    BIT                                 NULL,
  LaptopSerialNumber           VARCHAR(255)                        NULL,
  ExpectedGraduation           VARCHAR(255)                        NULL,
  SEESATScores                 VARCHAR(255)                        NULL,
  AdmissionSemester            VARCHAR(255)                        NULL,
  AdmissionMajor               VARCHAR(255)                        NULL,
  CurrentMajor                 INT                                 NULL,
  TD                           BIT                                 NULL,
  SIIDate                      DATE                                NULL,
  AcademicCoordinator          VARCHAR(255)                        NULL,
  StudentMentor                VARCHAR(255)                        NULL,
  CommunityDevelopmentProject  VARCHAR(255)                        NULL,
  BankAccount                  VARCHAR(255)                        NULL,
  Branch                       VARCHAR(255)                        NULL,
  IDPCompleted                 BIT                                 NULL,
  EligibilitySummer            BIT                                 NULL,
  SummersTakenCount            VARCHAR(255)                        NULL,
  ReferredToCounselor          BIT                                 NULL,
  CSPCompleted                 BIT                                 NULL,
  SchoolBackground             VARCHAR(255)                        NULL,
  IsGraduated                  BIT DEFAULT b'0'                    NULL,
  OverallImpression            VARCHAR(255)                        NULL,
  Issues                       VARCHAR(255)                        NULL,
  Faculty                      VARCHAR(255)                        NULL,
  OldMajor                     VARCHAR(255)                        NULL,
  ConditionsChangeMajor        VARCHAR(255)                        NULL,
  EnrolledTeachingDiploma      VARCHAR(255)                        NULL,
  ParticipatedUSPSponsored     VARCHAR(255)                        NULL,
  EnrolledDoubleMajor          BIT                                 NULL,
  EnrolledMajorMinor           BIT                                 NULL,
  CurrentEnrollmentStatus      VARCHAR(255)                        NULL,
  Probation                    BIT                                 NULL,
  ProbationRemovalDeadline     VARCHAR(255)                        NULL,
  MeritStatus                  VARCHAR(255)                        NULL,
  Internship                   VARCHAR(255)                        NULL,
  InternshipHost               VARCHAR(255)                        NULL,
  EngagedWorkshops             VARCHAR(255)                        NULL,
  EngagedSoftSkills            VARCHAR(255)                        NULL,
  EngagedEntrepreneurship      VARCHAR(255)                        NULL,
  Duration                     DATE                                NULL,
  Certificate                  BIT                                 NULL,
  LeadershipTraining           VARCHAR(255)                        NULL,
  CivicEngagement              VARCHAR(255)                        NULL,
  CommunityService             VARCHAR(255)                        NULL,
  USPCompetition               VARCHAR(255)                        NULL,
  StudentClub                  VARCHAR(255)                        NULL,
  NameOfClub                   VARCHAR(255)                        NULL,
  TookAcademicCourseLeadership BIT                                 NULL,
  IsUpdatingIDP                BIT                                 NULL,
  EmploymentStatus             VARCHAR(255)                        NULL,
  EmploymentLocation           VARCHAR(255)                        NULL,
  StartOfEmployment            DATE                                NULL,
  IsFullTimePosition           BIT                                 NULL,
  GraduateStudies              VARCHAR(255)                        NULL,
  GraduateStudiesLocation      VARCHAR(255)                        NULL,
  DateOfPhoneCall              DATE                                NULL,
  PhoneCallMadeBy              VARCHAR(255)                        NULL,
  RemarkableAchievements       VARCHAR(255)                        NULL,
  EnrollmentConditions         VARCHAR(255)                        NULL,
  SupportProgram               VARCHAR(255)                        NULL,
  HousingTransportAllowance    VARCHAR(255)                        NULL,
  PreparatorySemester          BIT                                 NULL,
  IsDeleted                    BIT DEFAULT b'0'                    NULL,
  CreatedByUserId              INT                                 NOT NULL,
  DateAdded                    TIMESTAMP DEFAULT CURRENT_TIMESTAMP NULL
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE INDEX CycleId
  ON student (CycleId);

CREATE TABLE studentcourseenrollment
(
  StudentCourseEnrollmentId   INT AUTO_INCREMENT
    PRIMARY KEY,
  StudentSemesterEnrollmentId INT                                 NOT NULL,
  OfferedCourseId             INT                                 NOT NULL,
  FinalGrade                  DOUBLE                              NULL,
  IsDropped                   BIT DEFAULT b'0'                    NOT NULL,
  IsDeleted                   BIT DEFAULT b'0'                    NOT NULL,
  CreatedByUserId             INT                                 NOT NULL,
  DateAdded                   TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  CONSTRAINT studentcourseenrollment_ibfk_3
  FOREIGN KEY (OfferedCourseId) REFERENCES offeredcourse (OfferedCourseId)
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE INDEX StudentSemesterEnrollmentId
  ON studentcourseenrollment (StudentSemesterEnrollmentId);

CREATE INDEX OfferedCourseId
  ON studentcourseenrollment (OfferedCourseId);

CREATE TABLE studentcourseevaluation
(
  StudentCourseEvaluationId   INT AUTO_INCREMENT
    PRIMARY KEY,
  StudentCourseEnrollmentId   INT                                 NOT NULL,
  InstructorEvaluationEmailId INT                                 NOT NULL,
  StudentId                   INT                                 NOT NULL,
  NumberOfAbsences            INT                                 NULL,
  Grade                       DOUBLE                              NULL,
  HomeWork                    DOUBLE                              NULL,
  Participation               VARCHAR(20)                         NULL,
  Effort                      VARCHAR(20)                         NULL,
  Attitude                    VARCHAR(20)                         NULL,
  Evaluation                  VARCHAR(20)                         NULL,
  InstructorNotes             VARCHAR(255)                        NULL,
  UserNote                    VARCHAR(255)                        NULL,
  AdminNote                   VARCHAR(255)                        NULL,
  IsDeleted                   BIT DEFAULT b'0'                    NOT NULL,
  DateAdded                   TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  Exam1                       INT                                 NULL,
  Exam2                       INT                                 NULL,
  Final                       INT                                 NULL,
  Other                       VARCHAR(255)                        NULL,
  Other2                      VARCHAR(255)                        NULL,
  Other3                      VARCHAR(255)                        NULL,
  CONSTRAINT studentcourseevaluation_ibfk_1
  FOREIGN KEY (InstructorEvaluationEmailId) REFERENCES instructorevaluationemail (InstructorEvaluationEmailId),
  CONSTRAINT studentcourseevaluation_ibfk_2
  FOREIGN KEY (StudentId) REFERENCES student (StudentId),
  CONSTRAINT studentcourseevaluation_ibfk_3
  FOREIGN KEY (StudentCourseEnrollmentId) REFERENCES studentcourseenrollment (StudentCourseEnrollmentId)
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE INDEX InstructorEvaluationEmailId
  ON studentcourseevaluation (InstructorEvaluationEmailId);

CREATE INDEX StudentId
  ON studentcourseevaluation (StudentId);

CREATE TABLE studyplan
(
  StudyPlanId     INT AUTO_INCREMENT PRIMARY KEY,
  MajorId         INT                                 NOT NULL,
  CourseLetter    VARCHAR(50)                         NOT NULL,
  Year            TINYINT(1)                          NOT NULL,
  Season          VARCHAR(8)                          NOT NULL,
  CreatedByUserId INT                                 NOT NULL,
  DateAdded       TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  IsDeleted       BIT DEFAULT b'0'                    NOT NULL,
  CONSTRAINT studentplanrow_ibfk_1
  FOREIGN KEY (MajorId) REFERENCES major (MajorId)
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;


CREATE TABLE studentsemesterenrollment
(
  StudentSemesterEnrollmentId INT AUTO_INCREMENT
    PRIMARY KEY,
  StudentId                   INT                                 NOT NULL,
  SemesterId                  INT                                 NOT NULL,
  IsDeleted                   BIT DEFAULT b'0'                    NOT NULL,
  CreatedByUserId             INT                                 NOT NULL,
  DateAdded                   TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  CONSTRAINT studentsemesterenrollment_ibfk_1
  FOREIGN KEY (StudentId) REFERENCES student (StudentId),
  CONSTRAINT studentsemesterenrollment_ibfk_2
  FOREIGN KEY (SemesterId) REFERENCES semester (SemesterId)
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

CREATE INDEX StudentId
  ON studentsemesterenrollment (StudentId);

CREATE INDEX SemesterId
  ON studentsemesterenrollment (SemesterId);

ALTER TABLE studentcourseenrollment
  ADD CONSTRAINT studentcourseenrollment_ibfk_2
FOREIGN KEY (StudentSemesterEnrollmentId) REFERENCES studentsemesterenrollment (StudentSemesterEnrollmentId);

CREATE TABLE user
(
  UserId          INT AUTO_INCREMENT
    PRIMARY KEY,
  Username        VARCHAR(255)                        NOT NULL,
  Password        VARCHAR(255)                        NOT NULL,
  Email           VARCHAR(255)                        NOT NULL,
  FirstName       VARCHAR(255)                        NOT NULL,
  LastName        VARCHAR(255)                        NOT NULL,
  Type            INT                                 NOT NULL,
  IsDeleted       BIT DEFAULT b'0'                    NOT NULL,
  CreatedByUserId INT                                 NOT NULL,
  DateAdded       TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
)
  ENGINE = InnoDB
  COLLATE = utf8_bin;

--
-- Dumping data for table `campus`
--

INSERT INTO `campus` (`CampusId`, `Name`, `IsDeleted`) VALUES
  (1, 'Beirut', b'0'),
  (2, 'Byblos', b'0');

--
-- Dumping data for table `season`
--

INSERT INTO `season` (`SeasonId`, `Name`, `IsDeleted`) VALUES
  (1, 'Spring', b'0'),
  (2, 'Fall', b'0'),
  (3, 'Summer', b'0');

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserId`, `Username`, `Password`, `Email`, `FirstName`, `LastName`, `Type`, `IsDeleted`, `CreatedByUserId`, `DateAdded`)
VALUES
  (1, 'admin', 'admin', 'admin@admin.com', 'Admin', 'Admin', 1, 0, 0, '2018-05-15 17:04:57'),
  (2, 'user', 'user', 'user@user.com', 'User', 'User', 2, 0, 0, '2018-05-15 17:06:17');