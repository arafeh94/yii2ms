<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property int $DepartmentId
 * @property int $SchoolId
 * @property string $Name
 * @property int $CreatedByUserId
 * @property string $DateAdded
 * @property bool $IsDeleted
 *
 * @property School $school
 * @property Major[] $majors
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SchoolId', 'Name', 'CreatedByUserId'], 'required'],
            [['SchoolId', 'CreatedByUserId'], 'integer'],
            [['DateAdded'], 'safe'],
            [['IsDeleted'], 'boolean'],
            [['Name'], 'string', 'max' => 255],
            [['Name'], 'unique', 'targetAttribute' => ['Name'], 'filter' => ['IsDeleted' => 0]],
            [['SchoolId'], 'exist', 'skipOnError' => true, 'targetClass' => School::className(), 'targetAttribute' => ['SchoolId' => 'SchoolId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DepartmentId' => Yii::t('app', 'Department ID'),
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
    public function getSchool()
    {
        return $this->hasOne(School::className(), ['SchoolId' => 'SchoolId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMajors()
    {
        return $this->hasMany(Major::className(), ['DepartmentId' => 'DepartmentId']);
    }

    /**
     * @inheritdoc
     * @return DepartmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DepartmentQuery(get_called_class());
    }
}
