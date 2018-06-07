<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "evaluationemail".
 *
 * @property int $EvaluationEmailId
 * @property int $SemesterId
 * @property string $Date
 * @property string $Quarter
 * @property bool $IsEnabled
 * @property bool $AvailableForInstructors
 * @property string $Description
 * @property int $CreatedByUserId
 * @property string $DateAdded
 * @property bool $IsDeleted
 *
 * @property Semester $semester
 * @property InstructorEvaluationEmail[] $instructorEvaluationEmails
 */
class EvaluationEmail extends ActiveRecord
{

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->CreatedByUserId = Yii::$app->user->identity->getId();
        }
        return parent::beforeSave($insert);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluationemail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['EvaluationEmailId', 'SemesterId', 'CreatedByUserId', 'AvailableForInstructors'], 'integer'],
            [['SemesterId', 'Date', 'Quarter', 'Description'], 'required'],
            [['Date', 'DateAdded'], 'safe'],
            [['IsEnabled', 'IsDeleted'], 'boolean'],
            [['Quarter'], 'string', 'max' => 25],
            [['Description'], 'string', 'max' => 255],
            [['SemesterId'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::className(), 'targetAttribute' => ['SemesterId' => 'SemesterId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'EvaluationEmailId' => Yii::t('app', 'Evaluation Email'),
            'SemesterId' => Yii::t('app', 'Semester'),
            'Date' => Yii::t('app', 'Date'),
            'Quarter' => Yii::t('app', 'Quarter'),
            'IsEnabled' => Yii::t('app', 'Is Enabled'),
            'AvailableForInstructors' => Yii::t('app', 'Available For Instructors'),
            'Description' => Yii::t('app', 'Description'),
            'CreatedByUserId' => Yii::t('app', 'Created By User ID'),
            'DateAdded' => Yii::t('app', 'Date Added'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemester()
    {
        return $this->hasOne(Semester::className(), ['SemesterId' => 'SemesterId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructorEvaluationEmails()
    {
        return $this->hasMany(InstructorEvaluationEmail::className(), ['EvaluationEmailId' => 'EvaluationEmailId']);
    }

    /**
     * @inheritdoc
     * @return EvaluationEmailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EvaluationEmailQuery(get_called_class());
    }
}
