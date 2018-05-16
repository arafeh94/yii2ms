<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "studentsemesterenrollment".
 *
 * @property int $StudentSemesterEnrollmentId
 * @property int $StudentId
 * @property int $SemesterId
 * @property bool $IsDeleted
 * @property int $CreatedByUserId
 * @property string $DateAdded
 *
 * @property StudentCourseEnrollment[] $studentCourseEnrollment
 * @property Student $student
 * @property Semester $semester
 */
class StudentSemesterEnrollment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'studentsemesterenrollment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StudentId', 'SemesterId', 'CreatedByUserId'], 'required'],
            [['StudentId', 'SemesterId', 'CreatedByUserId'], 'integer'],
            [['IsDeleted'], 'boolean'],
            [['DateAdded'], 'safe'],
            [['StudentId'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['StudentId' => 'StudentId']],
            [['SemesterId'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::className(), 'targetAttribute' => ['SemesterId' => 'SemesterId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StudentSemesterEnrollmentId' => Yii::t('app', 'Student Semester Enrollment ID'),
            'StudentId' => Yii::t('app', 'Student ID'),
            'SemesterId' => Yii::t('app', 'Semester ID'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
            'CreatedByUserId' => Yii::t('app', 'Created By User ID'),
            'DateAdded' => Yii::t('app', 'Date Added'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentCourseEnrollments()
    {
        return $this->hasMany(StudentCourseEnrollment::className(), ['StudentSemesterEnrollmentId' => 'StudentSemesterEnrollmentId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['StudentId' => 'StudentId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemester()
    {
        return $this->hasOne(Semester::className(), ['SemesterId' => 'SemesterId']);
    }

    /**
     * @inheritdoc
     * @return StudentSemesterEnrollmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StudentSemesterEnrollmentQuery(get_called_class());
    }
}
