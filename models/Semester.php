<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semester".
 *
 * @property int $SemesterId
 * @property int $Year
 * @property int $SeasonId
 * @property string $StartDate
 * @property string $EndDate
 * @property bool $IsCurrent
 * @property int $CreatedByUserId
 * @property string $DateAdded
 * @property bool $IsDeleted
 *
 * @property EvaluationEmail[] $evaluationEmails
 * @property OfferedCourse[] $offeredCourse
 * @property Season $season
 * @property StudentSemesterEnrollment[] $studentSemesterEnrollment
 */
class Semester extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semester';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Year', 'SeasonId', 'StartDate', 'EndDate', 'CreatedByUserId'], 'required'],
            [['Year', 'SeasonId', 'CreatedByUserId'], 'integer'],
            [['StartDate', 'EndDate', 'DateAdded'], 'safe'],
            [['IsCurrent', 'IsDeleted'], 'boolean'],
            [['SeasonId'], 'exist', 'skipOnError' => true, 'targetClass' => Season::className(), 'targetAttribute' => ['SeasonId' => 'SeasonId']],
            ['EndDate', 'compare', 'compareAttribute' => 'StartDate', 'operator' => '>='],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SemesterId' => Yii::t('app', 'Semester ID'),
            'Year' => Yii::t('app', 'Year'),
            'SeasonId' => Yii::t('app', 'Season'),
            'StartDate' => Yii::t('app', 'Start Date'),
            'EndDate' => Yii::t('app', 'End Date'),
            'IsCurrent' => Yii::t('app', 'Is Current'),
            'CreatedByUserId' => Yii::t('app', 'Created By User ID'),
            'DateAdded' => Yii::t('app', 'Date Added'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluationEmails()
    {
        return $this->hasMany(EvaluationEmail::className(), ['SemesterId' => 'SemesterId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfferedCourses()
    {
        return $this->hasMany(Offeredcourse::className(), ['SemesterId' => 'SemesterId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeason()
    {
        return $this->hasOne(Season::className(), ['SeasonId' => 'SeasonId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentSemesterEnrollments()
    {
        return $this->hasMany(StudentSemesterEnrollment::className(), ['SemesterId' => 'SemesterId']);
    }

    /**
     * @inheritdoc
     * @return SemesterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SemesterQuery(get_called_class());
    }
}
