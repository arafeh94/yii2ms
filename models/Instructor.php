<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "instructor".
 *
 * @property int $InstructorId
 * @property string $UniversityId
 * @property string $FirstName
 * @property string $LastName
 * @property string $Email
 * @property string $PhoneExtension
 * @property string $Title
 * @property int $CreatedByUserId
 * @property string $DateAdded
 * @property bool $IsDeleted
 *
 * @property InstructorEvaluationEmail[] $instructorEvaluationEmails
 * @property OfferedCourse[] $offeredCourses
 */
class Instructor extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instructor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['UniversityId', 'FirstName', 'LastName', 'Email', 'PhoneExtension', 'Title'], 'required'],
            [['CreatedByUserId'], 'integer'],
            [['DateAdded'], 'safe'],
            [['IsDeleted'], 'boolean'],
            [['UniversityId'], 'string', 'max' => 9],
            [['FirstName', 'LastName', 'Email'], 'string', 'max' => 255],
            [['PhoneExtension'], 'string', 'max' => 6],
            [['Title'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'InstructorId' => Yii::t('app', 'Instructor'),
            'UniversityId' => Yii::t('app', 'University ID'),
            'FirstName' => Yii::t('app', 'First Name'),
            'LastName' => Yii::t('app', 'Last Name'),
            'Email' => Yii::t('app', 'Email'),
            'PhoneExtension' => Yii::t('app', 'Phone Extension'),
            'Title' => Yii::t('app', 'Title'),
            'CreatedByUserId' => Yii::t('app', 'Created By User ID'),
            'DateAdded' => Yii::t('app', 'Date Added'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    public function getFullName()
    {
        if ($this->FirstName && $this->LastName) {
            return $this->Title . '. ' . $this->FirstName . ' ' . $this->LastName;
        } else {
            return 'none';
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructorEvaluationEmails()
    {
        return $this->hasMany(InstructorEvaluationEmail::className(), ['InstructorId' => 'InstructorId']);
    }

    /**
     * @param bool $InCurrentSemester
     * @return \yii\db\ActiveQuery
     */
    public function getOfferedCourses($InCurrentSemester = true)
    {
        $query = $this->hasMany(OfferedCourse::className(), ['InstructorId' => 'InstructorId']);
        if ($InCurrentSemester) {
            $query->where(['offeredcourse.SemesterId' => Semester::find()->current()->SemesterId]);
        }
        return $query;
    }

    /**
     * @inheritdoc
     * @return InstructorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InstructorQuery(get_called_class());
    }
}
