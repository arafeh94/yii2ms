<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "studentplanrow".
 *
 * @property int $StudentPlanRowId
 * @property int $StudentPlanId
 * @property string $CourseLetter
 * @property int $Year
 * @property string $Season
 * @property int $CreatedByUserId
 * @property string $DateAdded
 * @property bool $IsDeleted
 *
 * @property StudentPlan $studentPlan
 */
class StudentPlanRow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'studentplanrow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StudentPlanId', 'CourseLetter', 'Year', 'Season', 'CreatedByUserId'], 'required'],
            [['StudentPlanId', 'Year', 'CreatedByUserId'], 'integer'],
            [['DateAdded'], 'safe'],
            [['IsDeleted'], 'boolean'],
            [['CourseLetter', 'Season'], 'string', 'max' => 8],
            [['StudentPlanId'], 'exist', 'skipOnError' => true, 'targetClass' => StudentPlan::className(), 'targetAttribute' => ['StudentPlanId' => 'StudentPlanId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StudentPlanRowId' => Yii::t('app', 'Student Plan Row ID'),
            'StudentPlanId' => Yii::t('app', 'Student Plan ID'),
            'CourseLetter' => Yii::t('app', 'Course Letter'),
            'Year' => Yii::t('app', 'Year'),
            'Season' => Yii::t('app', 'Season'),
            'CreatedByUserId' => Yii::t('app', 'Created By User ID'),
            'DateAdded' => Yii::t('app', 'Date Added'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentPlan()
    {
        return $this->hasOne(StudentPlan::className(), ['StudentPlanId' => 'StudentPlanId']);
    }

    /**
     * @inheritdoc
     * @return StudentPlanRowQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StudentPlanRowQuery(get_called_class());
    }
}
