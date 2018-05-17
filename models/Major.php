<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "major".
 *
 * @property int $MajorId
 * @property int $DepartmentId
 * @property string $Name
 * @property string $Abbreviation
 * @property int $RequiredCredits
 * @property int $CreatedByUserId
 * @property string $DateAdded
 * @property bool $IsDeleted
 *
 * @property Course[] $courses
 * @property Department $department
 * @property StudentPlan[] $studentPlan
 */
class Major extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'major';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DepartmentId', 'Name', 'Abbreviation', 'RequiredCredits', 'CreatedByUserId'], 'required'],
            [['DepartmentId', 'RequiredCredits', 'CreatedByUserId'], 'integer'],
            [['DateAdded'], 'safe'],
            [['IsDeleted'], 'boolean'],
            [['Name'], 'string', 'max' => 255],
            [['Abbreviation'], 'string', 'max' => 3],
            [['DepartmentId'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['DepartmentId' => 'DepartmentId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MajorId' => Yii::t('app', 'Major ID'),
            'DepartmentId' => Yii::t('app', 'Department'),
            'Name' => Yii::t('app', 'Name'),
            'Abbreviation' => Yii::t('app', 'Abbreviation'),
            'RequiredCredits' => Yii::t('app', 'Required Credits'),
            'CreatedByUserId' => Yii::t('app', 'Created By User'),
            'DateAdded' => Yii::t('app', 'Date Added'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::className(), ['MajorId' => 'MajorId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['DepartmentId' => 'DepartmentId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentPlans()
    {
        return $this->hasMany(StudentPlan::className(), ['MajorId' => 'MajorId']);
    }

    /**
     * @inheritdoc
     * @return MajorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MajorQuery(get_called_class());
    }
}
