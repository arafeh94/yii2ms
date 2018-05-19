<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property int $StudentId
 * @property int $CycleId
 * @property string $UniversityId
 * @property string $FirstName
 * @property string $LastName
 * @property string $FatherName
 * @property int $DOBMonth
 * @property int $DOBYear
 * @property string $Gender
 * @property string $PhoneNumber
 * @property string $Email
 * @property string $Village
 * @property string $Caza
 * @property string $Mouhafaza
 * @property string $SchoolName
 * @property double $TwelveGrade
 * @property double $TenGrade
 * @property double $ElevenGrade
 * @property double $EnglishExamScore
 * @property bool $IsDataEntryComplete
 * @property bool $IsInitialVettingDone
 * @property bool $VettingUpdated
 * @property bool $AntiTerrorismCertification
 * @property bool $StudentMOUSigned
 * @property bool $HasLaptop
 * @property string $LaptopSerialNumber
 * @property string $ExpectedGraduation
 * @property string $SEESATScores
 * @property string $AdmissionSemester
 * @property string $AdmissionMajor
 * @property int $CurrentMajor
 * @property string $TD
 * @property string $SIIDate
 * @property string $AcademicCoordinator
 * @property string $StudentMentor
 * @property string $CommunityDevelopmentProject
 * @property string $BankAccount
 * @property string $Branch
 * @property string $IDPCompleted
 * @property string $EligibilitySummer
 * @property string $SummersTakenCount
 * @property string $ReferredToCounselor
 * @property string $CSPCompleted
 * @property string $SchoolBackground
 * @property bool $IsGraduated
 * @property string $OverallImpression
 * @property string $Issues
 * @property string $Faculty
 * @property string $OldMajor
 * @property string $ConditionsChangeMajor
 * @property string $EnrolledTeachingDiploma
 * @property string $ParticipatedUSPSponsored
 * @property string $EnrolledDoubleMajor
 * @property string $EnrolledMajorMinor
 * @property string $CurrentEnrollmentStatus
 * @property string $Probation
 * @property string $ProbationRemovalDeadline
 * @property string $MeritStatus
 * @property string $Internship
 * @property string $InternshipHost
 * @property string $EngagedWorkshops
 * @property string $EngagedSoftSkills
 * @property string $EngagedEntrepreneurship
 * @property string $Duration
 * @property int $Certificate
 * @property string $LeadershipTraining
 * @property string $CivicEngagement
 * @property string $CommunityService
 * @property string $USPCompetition
 * @property string $StudentClub
 * @property string $NameOfClub
 * @property bool $TookAcademicCourseLeadership
 * @property bool $IsUpdatingIDP
 * @property string $EmploymentStatus
 * @property string $EmploymentLocation
 * @property string $StartOfEmployment
 * @property string $IsFullTimePosition
 * @property string $GraduateStudies
 * @property string $GraduateStudiesLocation
 * @property string $DateOfPhoneCall
 * @property string $PhoneCallMadeBy
 * @property string $RemarkableAchievements
 * @property string $EnrollmentConditions
 * @property string $SupportProgram
 * @property string $HousingTransportAllowance
 * @property string $PreparatorySemester
 * @property bool $IsDeleted
 * @property int $CreatedByUserId
 * @property string $DateAdded
 *
 * @property Cycle $cycle
 * @property StudentCourseEnrollment[] $studentCourseEnrollments
 * @property StudentCourseEvaluation[] $studentCourseEvaluation
 * @property StudentSemesterEnrollment[] $studentSemesterEnrollments
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CycleId', 'UniversityId', 'FirstName', 'FatherName', 'LastName', 'CreatedByUserId'], 'required'],
            [['CycleId', 'DOBMonth', 'DOBYear', 'CurrentMajor', 'Certificate', 'CreatedByUserId'], 'integer'],
            [['TwelveGrade', 'TenGrade', 'ElevenGrade', 'EnglishExamScore'], 'number'],
            [['IsDataEntryComplete', 'IsInitialVettingDone', 'VettingUpdated', 'AntiTerrorismCertification', 'StudentMOUSigned', 'HasLaptop', 'IsGraduated', 'TookAcademicCourseLeadership', 'IsUpdatingIDP', 'IsDeleted'], 'boolean'],
            [['SIIDate', 'Duration', 'StartOfEmployment', 'DateOfPhoneCall', 'DateAdded', 'OverallImpression', 'EnrollmentConditions', 'SupportProgram', 'HousingTransportAllowance', 'PreparatorySemester',], 'safe'],
            [['UniversityId'], 'string', 'max' => 9],
            [['FirstName', 'LastName', 'PhoneNumber', 'Email', 'Village', 'Caza', 'Mouhafaza', 'SchoolName', 'LaptopSerialNumber', 'ExpectedGraduation', 'SEESATScores', 'AdmissionSemester', 'AdmissionMajor', 'TD', 'AcademicCoordinator', 'StudentMentor', 'CommunityDevelopmentProject', 'BankAccount', 'Branch', 'IDPCompleted', 'EligibilitySummer', 'SummersTakenCount', 'ReferredToCounselor', 'CSPCompleted', 'SchoolBackground', 'OverallImpression', 'Issues', 'Faculty', 'OldMajor', 'ConditionsChangeMajor', 'EnrolledTeachingDiploma', 'ParticipatedUSPSponsored', 'EnrolledDoubleMajor', 'EnrolledMajorMinor', 'CurrentEnrollmentStatus', 'Probation', 'ProbationRemovalDeadline', 'MeritStatus', 'Internship', 'InternshipHost', 'EngagedWorkshops', 'EngagedSoftSkills', 'EngagedEntrepreneurship', 'LeadershipTraining', 'CivicEngagement', 'CommunityService', 'USPCompetition', 'StudentClub', 'NameOfClub', 'EmploymentStatus', 'EmploymentLocation', 'IsFullTimePosition', 'GraduateStudies', 'GraduateStudiesLocation', 'PhoneCallMadeBy', 'RemarkableAchievements', 'EnrollmentConditions', 'SupportProgram', 'HousingTransportAllowance', 'PreparatorySemester'], 'string', 'max' => 255],
            [['Gender'], 'string', 'max' => 1],
            [['CycleId'], 'exist', 'skipOnError' => true, 'targetClass' => Cycle::className(), 'targetAttribute' => ['CycleId' => 'CycleId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StudentId' => Yii::t('app', 'Student ID'),
            'CycleId' => Yii::t('app', 'Cycle'),
            'UniversityId' => Yii::t('app', 'University ID'),
            'FirstName' => Yii::t('app', 'First Name'),
            'LastName' => Yii::t('app', 'Last Name'),
            'FatherName' => Yii::t('app', 'Father Name'),
            'DOBMonth' => Yii::t('app', 'Dobmonth'),
            'DOBYear' => Yii::t('app', 'Dobyear'),
            'Gender' => Yii::t('app', 'Gender'),
            'PhoneNumber' => Yii::t('app', 'Phone Number'),
            'Email' => Yii::t('app', 'Email'),
            'Village' => Yii::t('app', 'Village'),
            'Caza' => Yii::t('app', 'Caza'),
            'Mouhafaza' => Yii::t('app', 'Mouhafaza'),
            'SchoolName' => Yii::t('app', 'School Name'),
            'TwelveGrade' => Yii::t('app', 'Twelve Grade'),
            'TenGrade' => Yii::t('app', 'Ten Grade'),
            'ElevenGrade' => Yii::t('app', 'Eleven Grade'),
            'EnglishExamScore' => Yii::t('app', 'English Exam Score'),
            'IsDataEntryComplete' => Yii::t('app', 'Is Data Entry Complete'),
            'IsInitialVettingDone' => Yii::t('app', 'Is Initial Vetting Done'),
            'VettingUpdated' => Yii::t('app', 'Vetting Updated'),
            'AntiTerrorismCertification' => Yii::t('app', 'Anti Terrorism Certification'),
            'StudentMOUSigned' => Yii::t('app', 'Student Mousigned'),
            'HasLaptop' => Yii::t('app', 'Has Laptop'),
            'LaptopSerialNumber' => Yii::t('app', 'Laptop Serial Number'),
            'ExpectedGraduation' => Yii::t('app', 'Expected Graduation'),
            'SEESATScores' => Yii::t('app', 'Seesatscores'),
            'AdmissionSemester' => Yii::t('app', 'Admission Semester'),
            'AdmissionMajor' => Yii::t('app', 'Admission Major'),
            'CurrentMajor' => Yii::t('app', 'Current Major'),
            'TD' => Yii::t('app', 'Td'),
            'SIIDate' => Yii::t('app', 'Siidate'),
            'AcademicCoordinator' => Yii::t('app', 'Academic Coordinator'),
            'StudentMentor' => Yii::t('app', 'Student Mentor'),
            'CommunityDevelopmentProject' => Yii::t('app', 'Community Development Project'),
            'BankAccount' => Yii::t('app', 'Bank Account'),
            'Branch' => Yii::t('app', 'Branch'),
            'IDPCompleted' => Yii::t('app', 'Idpcompleted'),
            'EligibilitySummer' => Yii::t('app', 'Eligibility Summer'),
            'SummersTakenCount' => Yii::t('app', 'Summers Taken Count'),
            'ReferredToCounselor' => Yii::t('app', 'Referred To Counselor'),
            'CSPCompleted' => Yii::t('app', 'Cspcompleted'),
            'SchoolBackground' => Yii::t('app', 'School Background'),
            'IsGraduated' => Yii::t('app', 'Is Graduated'),
            'OverallImpression' => Yii::t('app', 'Overall Impression'),
            'Issues' => Yii::t('app', 'Issues'),
            'Faculty' => Yii::t('app', 'Faculty'),
            'OldMajor' => Yii::t('app', 'Old Major'),
            'ConditionsChangeMajor' => Yii::t('app', 'Conditions Change Major'),
            'EnrolledTeachingDiploma' => Yii::t('app', 'Enrolled Teaching Diploma'),
            'ParticipatedUSPSponsored' => Yii::t('app', 'Participated Uspsponsored'),
            'EnrolledDoubleMajor' => Yii::t('app', 'Enrolled Double Major'),
            'EnrolledMajorMinor' => Yii::t('app', 'Enrolled Major Minor'),
            'CurrentEnrollmentStatus' => Yii::t('app', 'Current Enrollment Status'),
            'Probation' => Yii::t('app', 'Probation'),
            'ProbationRemovalDeadline' => Yii::t('app', 'Probation Removal Deadline'),
            'MeritStatus' => Yii::t('app', 'Merit Status'),
            'Internship' => Yii::t('app', 'Internship'),
            'InternshipHost' => Yii::t('app', 'Internship Host'),
            'EngagedWorkshops' => Yii::t('app', 'Engaged Workshops'),
            'EngagedSoftSkills' => Yii::t('app', 'Engaged Soft Skills'),
            'EngagedEntrepreneurship' => Yii::t('app', 'Engaged Entrepreneurship'),
            'Duration' => Yii::t('app', 'Duration'),
            'Certificate' => Yii::t('app', 'Certificate'),
            'LeadershipTraining' => Yii::t('app', 'Leadership Training'),
            'CivicEngagement' => Yii::t('app', 'Civic Engagement'),
            'CommunityService' => Yii::t('app', 'Community Service'),
            'USPCompetition' => Yii::t('app', 'Uspcompetition'),
            'StudentClub' => Yii::t('app', 'Student Club'),
            'NameOfClub' => Yii::t('app', 'Name Of Club'),
            'TookAcademicCourseLeadership' => Yii::t('app', 'Took Academic Course Leadership'),
            'IsUpdatingIDP' => Yii::t('app', 'Is Updating Idp'),
            'EmploymentStatus' => Yii::t('app', 'Employment Status'),
            'EmploymentLocation' => Yii::t('app', 'Employment Location'),
            'StartOfEmployment' => Yii::t('app', 'Start Of Employment'),
            'IsFullTimePosition' => Yii::t('app', 'Is Full Time Position'),
            'GraduateStudies' => Yii::t('app', 'Graduate Studies'),
            'GraduateStudiesLocation' => Yii::t('app', 'Graduate Studies Location'),
            'DateOfPhoneCall' => Yii::t('app', 'Date Of Phone Call'),
            'PhoneCallMadeBy' => Yii::t('app', 'Phone Call Made By'),
            'RemarkableAchievements' => Yii::t('app', 'Remarkable Achievements'),
            'EnrollmentConditions' => Yii::t('app', 'Enrollment Conditions'),
            'SupportProgram' => Yii::t('app', 'Support Program'),
            'HousingTransportAllowance' => Yii::t('app', 'Housing Transport Allowance'),
            'PreparatorySemester' => Yii::t('app', 'Preparatory Semester'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
            'CreatedByUserId' => Yii::t('app', 'Created By User ID'),
            'DateAdded' => Yii::t('app', 'Date Added'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCycle()
    {
        return $this->hasOne(Cycle::className(), ['CycleId' => 'CycleId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentCourseEnrollments()
    {
        return $this->hasMany(StudentCourseEnrollment::className(), ['StudentCourseEnrollmentId' => 'StudentId'])
            ->via('studentSemesterEnrollments');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentCourseEvaluations()
    {
        return $this->hasMany(StudentCourseEvaluation::className(), ['StudentId' => 'StudentId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentSemesterEnrollments()
    {
        return $this->hasMany(StudentSemesterEnrollment::className(), ['StudentId' => 'StudentId']);
    }

    /**
     * @inheritdoc
     * @return StudentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StudentQuery(get_called_class());
    }
}
