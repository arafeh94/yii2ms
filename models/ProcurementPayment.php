<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procurement_payment".
 *
 * @property int $id
 * @property int $procurement_id
 * @property double $amount
 * @property string $date
 * @property int $is_deleted
 *
 * @property Procurement $procurement
 */
class ProcurementPayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'procurement_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['procurement_id', 'is_deleted'], 'integer'],
            [['amount'], 'number'],
            [['date'], 'safe'],
            [['procurement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Procurement::className(), 'targetAttribute' => ['procurement_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'procurement_id' => Yii::t('app', 'Procurement'),
            'amount' => Yii::t('app', 'Amount'),
            'date' => Yii::t('app', 'Date'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcurement()
    {
        return $this->hasOne(Procurement::className(), ['id' => 'procurement_id']);
    }
}
