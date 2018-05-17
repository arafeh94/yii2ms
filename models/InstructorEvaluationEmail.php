<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "instructorevaluationemail".
 *
 * @property int $InstructorEvaluationEmailId
 * @property int $EvaluationEmailId
 * @property int $InstructorId
 * @property string $EvaluationCode
 * @property string $DateFilled
 * @property bool $IsDeleted
 *
 * @property Instructor $instructor
 * @property StudentCourseEvaluation[] $studentCourseEvaluation
 */
class InstructorEvaluationEmail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instructorevaluationemail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['EvaluationEmailId', 'InstructorId', 'EvaluationCode'], 'required'],
            [['EvaluationEmailId', 'InstructorId'], 'integer'],
            [['DateFilled'], 'safe'],
            [['IsDeleted'], 'boolean'],
            [['EvaluationCode'], 'string', 'max' => 25],
            [['InstructorId'], 'exist', 'skipOnError' => true, 'targetClass' => Instructor::className(), 'targetAttribute' => ['InstructorId' => 'InstructorId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'InstructorEvaluationEmailId' => Yii::t('app', 'Instructor Evaluation Email ID'),
            'EvaluationEmailId' => Yii::t('app', 'Evaluation Email ID'),
            'InstructorId' => Yii::t('app', 'Instructor ID'),
            'EvaluationCode' => Yii::t('app', 'Evaluation Code'),
            'DateFilled' => Yii::t('app', 'Date Filled'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstructor()
    {
        return $this->hasOne(Instructor::className(), ['InstructorId' => 'InstructorId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentCourseEvaluations()
    {
        return $this->hasMany(StudentCourseEvaluation::className(), ['InstructorEvaluationEmailId' => 'InstructorEvaluationEmailId']);
    }

    /**
     * @inheritdoc
     * @return InstructorEvaluationEmailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InstructorEvaluationEmailQuery(get_called_class());
    }
}