<?php

namespace app\models;

use app\components\Cached;
use Yii;

/**
 * This is the model class for table "offeredcourse".
 *
 * @property int $OfferedCourseId
 * @property int $CampusId
 * @property int $SemesterId
 * @property int $InstructorId
 * @property int $CourseId
 * @property int $CRN
 * @property int $Section
 * @property int $CreatedByUserId
 * @property string $DateAdded
 * @property bool $IsDeleted
 *
 * @property Semester $semester
 * @property Course $course
 * @property Instructor $instructor
 * @property Campus $campus
 * @property StudentCourseEnrollment[] $studentCourseEnrollments
 */
class OfferedCourse extends \yii\db\ActiveRecord
{


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'offeredcourse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CampusId', 'SemesterId', 'InstructorId', 'CourseId', 'CRN', 'Section'], 'required'],
            [['CampusId', 'SemesterId', 'InstructorId', 'CourseId', 'CRN', 'Section', 'CreatedByUserId'], 'integer'],
            [['DateAdded'], 'safe'],
            [['IsDeleted'], 'boolean'],
            [['SemesterId'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::className(), 'targetAttribute' => ['SemesterId' => 'SemesterId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'OfferedCourseId' => Yii::t('app', 'Offered Course ID'),
            'CampusId' => Yii::t('app', 'Campus'),
            'SemesterId' => Yii::t('app', 'Semester'),
            'InstructorId' => Yii::t('app', 'Instructor'),
            'CourseId' => Yii::t('app', 'Course'),
            'CRN' => Yii::t('app', 'Crn'),
            'Section' => Yii::t('app', 'Section'),
            'CreatedByUserId' => Yii::t('app', 'Created By User ID'),
            'DateAdded' => Yii::t('app', 'Date Added'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemester()
    {
        return $this->hasOne(Semester::className(), ['SemesterId' => 'SemesterId'])->where(['semester.IsDeleted' => 0]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampus()
    {
        return $this->hasOne(Campus::className(), ['CampusId' => 'CampusId'])->where(['campus.IsDeleted' => 0]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['CourseId' => 'CourseId'])->where(['course.IsDeleted' => 0]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructor()
    {
        return $this->hasOne(Instructor::className(), ['InstructorId' => 'InstructorId'])->where(['instructor.IsDeleted' => 0]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentCourseEnrollments()
    {
        return $this->hasMany(StudentCourseEnrollment::className(), ['OfferedCourseId' => 'OfferedCourseId'])->where(['studentcourseenrollment.IsDeleted' => 0]);
    }

    /**
     * @inheritdoc
     * @return OfferedCourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OfferedCourseQuery(get_called_class());
    }
}
