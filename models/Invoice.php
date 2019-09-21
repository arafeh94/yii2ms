<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property int $project_id
 * @property string $code
 * @property string $old_code
 * @property string $ref
 * @property string $description
 * @property double $quantity
 * @property double $price
 * @property double $itl_price
 * @property string $inv_ref
 * @property string $se_ref
 * @property string $order_status
 * @property string $fob_cost
 * @property string $fob_itl
 * @property double $price_usd
 * @property int $is_deleted
 *
 * @property Project $project
 * @property int $brand_id [int(11)]
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'is_deleted'], 'integer'],
            [['quantity', 'price', 'itl_price', 'price_usd'], 'number'],
            [['code', 'old_code', 'ref', 'description', 'inv_ref', 'se_ref', 'order_status', 'fob_cost', 'fob_itl'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['is_deleted'], 'safe']
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
            'code' => Yii::t('app', 'Code'),
            'old_code' => Yii::t('app', 'Old Code'),
            'ref' => Yii::t('app', 'Ref'),
            'description' => Yii::t('app', 'Description'),
            'quantity' => Yii::t('app', 'Quantity'),
            'price' => Yii::t('app', 'Price'),
            'itl_price' => Yii::t('app', 'Itl Price'),
            'inv_ref' => Yii::t('app', 'Inv Ref'),
            'se_ref' => Yii::t('app', 'Se Ref'),
            'order_status' => Yii::t('app', 'Order Status'),
            'fob_cost' => Yii::t('app', 'Fob Cost'),
            'fob_itl' => Yii::t('app', 'Fob Itl'),
            'price_usd' => Yii::t('app', 'Price Usd'),
            'brand_id' => Yii::t('app', 'Brand'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * @inheritdoc
     * @return InvoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvoiceQuery(get_called_class());
    }
}
