<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cycle".
 *
 * @property int $CycleId
 * @property string $Name
 * @property int $CreatedByUserId
 * @property string $DateAdded
 * @property bool $IsDeleted
 *
 * @property Student[] $students
 */
class Cycle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cycle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'CreatedByUserId'], 'required'],
            [['CreatedByUserId'], 'integer'],
            [['DateAdded'], 'safe'],
            [['IsDeleted'], 'boolean'],
            [['Name'], 'string', 'max' => 50],
            [['Name'], 'unique', 'targetAttribute' => ['Name'], 'filter' => ['IsDeleted' => 0]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CycleId' => Yii::t('app', 'Cycle ID'),
            'Name' => Yii::t('app', 'Name'),
            'CreatedByUserId' => Yii::t('app', 'Created By User ID'),
            'DateAdded' => Yii::t('app', 'Date Added'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['CycleId' => 'CycleId']);
    }

    /**
     * @inheritdoc
     * @return CycleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CycleQuery(get_called_class());
    }
}
