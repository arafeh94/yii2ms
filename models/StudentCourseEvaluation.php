<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "studentcourseevaluation".
 *
 * @property int $StudentCourseEvaluationId
 * @property int $StudentCourseEnrollmentId
 * @property int $InstructorEvaluationEmailId
 * @property int $StudentId
 * @property int $NumberOfAbsences
 * @property double $Grade
 * @property double $HomeWork
 * @property string $Participation
 * @property string $Effort
 * @property string $Attitude
 * @property string $Evaluation
 * @property string $InstructorNotes
 * @property string $UserNote
 * @property string $AdminNote
 * @property bool $IsDeleted
 * @property string $DateAdded
 *
 * @property InstructorEvaluationEmail $instructorEvaluationEmail
 * @property Student $student
 * @property StudentCourseEnrollment $studentCourseEnrollment
 */
class StudentCourseEvaluation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'studentcourseevaluation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StudentCourseEnrollmentId', 'InstructorEvaluationEmailId', 'StudentId'], 'required'],
            [['StudentCourseEnrollmentId', 'InstructorEvaluationEmailId', 'StudentId', 'NumberOfAbsences'], 'integer'],
            [['Grade', 'HomeWork'], 'number'],
            [['IsDeleted'], 'boolean'],
            [['DateAdded'], 'safe'],
            [['Participation', 'Effort', 'Attitude', 'Evaluation'], 'string', 'max' => 20],
            [['InstructorNotes', 'UserNote', 'AdminNote'], 'string', 'max' => 255],
            [['InstructorEvaluationEmailId'], 'exist', 'skipOnError' => true, 'targetClass' => Instructorevaluationemail::className(), 'targetAttribute' => ['InstructorEvaluationEmailId' => 'InstructorEvaluationEmailId']],
            [['StudentId'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['StudentId' => 'StudentId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StudentCourseEvaluationId' => Yii::t('app', 'Student Course Evaluation ID'),
            'StudentCourseEnrollmentId' => Yii::t('app', 'Student Course Enrollment ID'),
            'InstructorEvaluationEmailId' => Yii::t('app', 'Instructor Evaluation Email ID'),
            'StudentId' => Yii::t('app', 'Student ID'),
            'NumberOfAbsences' => Yii::t('app', 'Number Of Absences'),
            'Grade' => Yii::t('app', 'Grade'),
            'HomeWork' => Yii::t('app', 'Home Work'),
            'Participation' => Yii::t('app', 'Participation'),
            'Effort' => Yii::t('app', 'Effort'),
            'Attitude' => Yii::t('app', 'Attitude'),
            'Evaluation' => Yii::t('app', 'Evaluation'),
            'InstructorNotes' => Yii::t('app', 'Instructor Notes'),
            'UserNote' => Yii::t('app', 'User Note'),
            'AdminNote' => Yii::t('app', 'Admin Note'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
            'DateAdded' => Yii::t('app', 'Date Added'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructorEvaluationEmail()
    {
        return $this->hasOne(Instructorevaluationemail::className(), ['InstructorEvaluationEmailId' => 'InstructorEvaluationEmailId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentCourseEnrollment()
    {
        return $this->hasOne(StudentCourseEnrollment::className(), ['StudentCourseEnrollmentId' => 'StudentCourseEnrollmentId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['StudentId' => 'StudentId']);
    }

    /**
     * @inheritdoc
     * @return StudentCourseEvaluationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StudentCourseEvaluationQuery(get_called_class());
    }

    public function __toString()
    {
        return spl_object_hash($this);
    }
}
