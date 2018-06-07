<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "school".
 *
 * @property int $SchoolId
 * @property string $Name
 * @property int $CreatedByUserId
 * @property string $DateAdded
 * @property bool $IsDeleted
 *
 * @property Department[] $departments
 */
class School extends \yii\db\ActiveRecord
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
        return 'school';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['CreatedByUserId'], 'integer'],
            [['DateAdded'], 'safe'],
            [['IsDeleted'], 'boolean'],
            [['Name'], 'string', 'max' => 255],
            [['Name'], 'unique', 'targetAttribute' => ['Name'], 'filter' => ['IsDeleted' => 0]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SchoolId' => Yii::t('app', 'School'),
            'Name' => Yii::t('app', 'Name'),
            'CreatedByUserId' => Yii::t('app', 'Created By User ID'),
            'DateAdded' => Yii::t('app', 'Date Added'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Department::className(), ['SchoolId' => 'SchoolId']);
    }

    /**
     * @inheritdoc
     * @return SchoolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SchoolQuery(get_called_class());
    }
}
