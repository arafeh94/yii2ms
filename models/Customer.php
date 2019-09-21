<?php

namespace app\models;

use app\components\Tools;
use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $meta
 * @property int $attachment_id
 *
 * @property Project[] $projects
 * @property int $is_deleted [int(11)]
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['meta'], 'string'],
            [['attachment_id'], 'integer'],
            [['name', 'phone', 'email'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Name'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'meta' => Yii::t('app', 'Meta'),
            'attachment_id' => Yii::t('app', 'Attachment ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['customer_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }
}
