<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "studyplan".
 *
 * @property int $StudyPlanId
 * @property int $MajorId
 * @property string $CourseLetter
 * @property int $Year
 * @property string $Season
 * @property int $CreatedByUserId
 * @property string $DateAdded
 * @property bool $IsDeleted
 *
 * @property Major $major
 */
class StudyPlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'studyplan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MajorId', 'CourseLetter', 'Year', 'Season', 'CreatedByUserId'], 'required'],
            [['MajorId', 'Year', 'CreatedByUserId'], 'integer'],
            [['DateAdded'], 'safe'],
            [['IsDeleted'], 'boolean'],
            [['CourseLetter', 'Season'], 'string', 'max' => 8],
            [['MajorId'], 'exist', 'skipOnError' => true, 'targetClass' => Major::className(), 'targetAttribute' => ['MajorId' => 'MajorId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StudyPlanId' => Yii::t('app', 'Student Plan'),
            'MajorId' => Yii::t('app', 'Major'),
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
    public function getMajor()
    {
        return $this->hasOne(Major::className(), ['MajorId' => 'MajorId']);
    }

    /**
     * @inheritdoc
     * @return StudyPlanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StudyPlanQuery(get_called_class());
    }
}
