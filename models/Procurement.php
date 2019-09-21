<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procurement".
 *
 * @property int $id
 * @property int $project_id
 * @property int $supplier_id
 * @property int $brand_id
 * @property double $value
 * @property double $value_usd
 * @property string $fctr
 * @property string $se_cost
 * @property string $pr
 * @property string $type
 * @property string $terms
 * @property string $po_ref
 * @property string $po_date
 * @property string $se
 * @property string $se_status
 * @property int $is_deleted
 *
 * @property Brand $brand
 * @property Project $project
 * @property Supplier $supplier
 * @property ProcurementPayment[] $procurementPayments
 */
class Procurement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'procurement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'supplier_id', 'brand_id', 'is_deleted'], 'integer'],
            [['value', 'value_usd'], 'number'],
            [['po_date'], 'safe'],
            [['fctr', 'se_cost', 'pr', 'type', 'terms', 'po_ref', 'se', 'se_status'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier_id' => 'id']],
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
            'supplier_id' => Yii::t('app', 'Supplier'),
            'brand_id' => Yii::t('app', 'Brand'),
            'value' => Yii::t('app', 'Value'),
            'value_usd' => Yii::t('app', 'Value Usd'),
            'fctr' => Yii::t('app', 'Fctr'),
            'se_cost' => Yii::t('app', 'Se Cost'),
            'pr' => Yii::t('app', 'Pr'),
            'type' => Yii::t('app', 'Type'),
            'terms' => Yii::t('app', 'Terms'),
            'po_ref' => Yii::t('app', 'Po Ref'),
            'po_date' => Yii::t('app', 'Po Date'),
            'se' => Yii::t('app', 'Se'),
            'se_status' => Yii::t('app', 'Se Status'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
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
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcurementPayments()
    {
        return $this->hasMany(ProcurementPayment::className(), ['procurement_id' => 'id']);
    }
}
