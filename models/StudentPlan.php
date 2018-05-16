<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "StudentPlan".
 *
 * @property int $StudentPlanId
 * @property int $MajorId
 * @property int $CreatedByUserId
 * @property string $DateAdded
 * @property bool $IsDeleted
 */
class StudentPlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'StudentPlan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MajorId', 'CreatedByUserId'], 'required'],
            [['MajorId', 'CreatedByUserId'], 'integer'],
            [['DateAdded'], 'safe'],
            [['IsDeleted'], 'boolean'],
            [['MajorId'], 'exist', 'skipOnError' => true, 'targetClass' => Major::className(), 'targetAttribute' => ['MajorId' => 'MajorId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StudentPlanId' => Yii::t('app', 'Student Plan ID'),
            'MajorId' => Yii::t('app', 'Major ID'),
            'CreatedByUserId' => Yii::t('app', 'Created By User ID'),
            'DateAdded' => Yii::t('app', 'Date Added'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @inheritdoc
     * @return StudentPlanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StudentPlanQuery(get_called_class());
    }
}
