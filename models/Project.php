<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $category_id
 * @property int $priority
 * @property int $status
 * @property string $date_begin
 * @property string $date_end
 * @property double $order_value
 * @property int $po_number
 * @property string $notes
 * @property int $attachment_id
 * @property string $meta
 * @property int $is_deleted [int(11)]
 * @property string $name [varchar(255)]
 * @property int $company_id [int(11)]
 *
 * @property Customer $customer
 * @property Category $category
 * @property Company $company
 * @property Attachment $attachment
 * @property string $terms [varchar(255)]
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'category_id', 'priority', 'status', 'po_number', 'attachment_id', 'company_id'], 'integer'],
            [['date_begin', 'date_end'], 'safe'],
            [['order_value'], 'number'],
            [['notes', 'meta', 'name', 'terms'], 'string'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['attachment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attachment::className(), 'targetAttribute' => ['attachment_id' => 'id']],
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
            'customer_id' => Yii::t('app', 'Customer'),
            'category_id' => Yii::t('app', 'Category'),
            'company_id' => Yii::t('app', 'Company'),
            'name' => Yii::t('app', 'Name'),
            'priority' => Yii::t('app', 'Priority'),
            'terms' => Yii::t('app', 'Terms'),
            'status' => Yii::t('app', 'Status'),
            'date_begin' => Yii::t('app', 'Date Begin'),
            'date_end' => Yii::t('app', 'Date End'),
            'order_value' => Yii::t('app', 'Order Value'),
            'po_number' => Yii::t('app', 'Po Number'),
            'notes' => Yii::t('app', 'Notes'),
            'attachment_id' => Yii::t('app', 'Attachment ID'),
            'meta' => Yii::t('app', 'Meta'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttachment()
    {
        return $this->hasOne(Attachment::className(), ['id' => 'attachment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @inheritdoc
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }
}
