<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Student]].
 *
 * @see Student
 */
class StudentQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[student.IsDeleted]]=0');
    }

    public function id($id)
    {
        return $this->andWhere(['student.StudentId' => $id]);
    }

    public function universityId($id)
    {
        return $this->andWhere(['student.UniversityId' => $id]);
    }

    public function filter()
    {
        return $this->select([
            'StudentId',
            'EnrolledMajorMinor',
            'IsFullTimePosition',
            'PhoneCallMadeBy',
            'OverallImpression',
            'StudentClub',
            'CurrentMajor',
            'TwelveGrade',
            'Duration',
            'EnrolledTeachingDiploma',
            'NameOfClub',
            'TD',
            'ConditionsChangeMajor',
            'ProbationRemovalDeadline',
            'StartOfEmployment',
            'EmploymentLocation',
            'AdmissionMajor',
            'GraduateStudiesLocation',
            'SIIDate',
            'EmploymentStatus',
            'ExpectedGraduation',
            'ElevenGrade',
            'SupportProgram',
            'Mouhafaza',
            'DOBYear',
            'EngagedEntrepreneurship',
            'FatherName',
            'SchoolName',
            'IsInitialVettingDone',
            'CommunityDevelopmentProject',
            'CivicEngagement',
            'Issues',
            'VettingUpdated',
            'LeadershipTraining',
            'StudentMOUSigned',
            'BankAccount',
            'ParticipatedUSPSponsored',
            'TenGrade',
            'DateOfPhoneCall',
            'OldMajor',
            'IsUpdatingIDP',
            'LastName',
            'Branch',
            'Internship',
            'MeritStatus',
            'LaptopSerialNumber',
            'UniversityId',
            'CSPCompleted',
            'PreparatorySemester',
            'Gender',
            'StudentMentor',
            'SEESATScores',
            'Caza',
            'AdmissionSemester',
            'USPCompetition',
            'PhoneNumber',
            'Probation',
            'Email',
            'TookAcademicCourseLeadership',
            'CurrentEnrollmentStatus',
            'DOBMonth',
            'SummersTakenCount',
            'Village',
            'CycleId',
            'GraduateStudies',
            'CreatedByUserId',
            'InternshipHost',
            'EnrolledDoubleMajor',
            'SchoolBackground',
            'EngagedSoftSkills',
            'IsGraduated',
            'ReferredToCounselor',
            'HasLaptop',
            'EnrollmentConditions',
            'IDPCompleted',
            'IsDataEntryComplete',
            'AcademicCoordinator',
            'CommunityService',
            'EngagedWorkshops',
            'EligibilitySummer',
            'AntiTerrorismCertification',
            'Certificate',
            'RemarkableAchievements',
            'EnglishExamScore',
            'Faculty',
            'HousingTransportAllowance',
            'FirstName',
        ]);
    }

    /**
     * @inheritdoc
     * @return Student[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Student|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
