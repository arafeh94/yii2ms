<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_payment".
 *
 * @property int $id
 * @property int $project_id
 * @property string $method
 * @property double $amount
 * @property string $CRVRef
 * @property string $date_due
 * @property string $date_payment
 * @property string $meta
 * @property int $is_deleted
 *
 * @property Project $project
 */
class ProjectPayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'is_deleted'], 'integer'],
            [['amount'], 'number'],
            [['date_due', 'date_payment'], 'safe'],
            [['date_due', 'date_payment'], 'date', 'format' => 'y-M-d'],
            [['meta'], 'string'],
            [['method', 'CRVRef'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app', 'Project'),
            'method' => Yii::t('app', 'Method'),
            'amount' => Yii::t('app', 'Amount'),
            'CRVRef' => Yii::t('app', 'Crvref'),
            'date_due' => Yii::t('app', 'Date Due'),
            'date_payment' => Yii::t('app', 'Date Payment'),
            'meta' => Yii::t('app', 'Meta'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }


    /**
     * @inheritdoc
     * @return ProjectPaymentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectPaymentQuery(get_called_class());
    }

}
