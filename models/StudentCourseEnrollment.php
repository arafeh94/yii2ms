<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "studentcourseenrollment".
 *
 * @property int $StudentCourseEnrollmentId
 * @property int $StudentId
 * @property int $StudentSemesterEnrollmentId
 * @property int $OfferedCourseId
 * @property string $FinalGrade
 * @property bool $IsDropped
 * @property bool $IsDeleted
 * @property int $CreatedByUserId
 * @property string $DateAdded
 *
 * @property Student $student
 * @property StudentSemesterEnrollment $studentSemesterEnrollment
 * @property OfferedCourse $offeredCourse
 */
class StudentCourseEnrollment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'studentcourseenrollment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StudentId', 'StudentSemesterEnrollmentId', 'OfferedCourseId', 'CreatedByUserId'], 'required'],
            [['StudentId', 'StudentSemesterEnrollmentId', 'OfferedCourseId', 'CreatedByUserId'], 'integer'],
            [['IsDropped', 'IsDeleted'], 'boolean'],
            [['DateAdded'], 'safe'],
            [['FinalGrade'], 'string', 'max' => 255],
            [['StudentId'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['StudentId' => 'StudentId']],
            [['StudentSemesterEnrollmentId'], 'exist', 'skipOnError' => true, 'targetClass' => Studentsemesterenrollment::className(), 'targetAttribute' => ['StudentSemesterEnrollmentId' => 'StudentSemesterEnrollmentId']],
            [['OfferedCourseId'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['OfferedCourseId' => 'CourseId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StudentCourseEnrollmentId' => Yii::t('app', 'Student Course Enrollment ID'),
            'StudentId' => Yii::t('app', 'Student ID'),
            'StudentSemesterEnrollmentId' => Yii::t('app', 'Student Semester Enrollment ID'),
            'OfferedCourseId' => Yii::t('app', 'Offered Course ID'),
            'FinalGrade' => Yii::t('app', 'Final Grade'),
            'IsDropped' => Yii::t('app', 'Is Dropped'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
            'CreatedByUserId' => Yii::t('app', 'Created By User ID'),
            'DateAdded' => Yii::t('app', 'Date Added'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentSemesterEnrollment()
    {
        return $this->hasOne(StudentSemesterEnrollment::className(), ['StudentSemesterEnrollmentId' => 'StudentSemesterEnrollmentId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['StudentId' => 'StudentSemesterEnrollmentId'])
            ->via('studentSemesterEnrollment')->inverseOf('studentCourseEnrollments');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfferedCourse()
    {
        return $this->hasOne(OfferedCourse::className(), ['OfferedCourseId' => 'OfferedCourseId']);
    }

    /**
     * @inheritdoc
     * @return StudentcourseEnrollmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StudentcourseEnrollmentQuery(get_called_class());
    }
}
