<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "season".
 *
 * @property int $SeasonId
 * @property string $Name
 * @property bool $IsDeleted
 *
 * @property Semester[] $semesters
 */
class Season extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'season';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IsDeleted'], 'boolean'],
            [['Name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SeasonId' => Yii::t('app', 'Season'),
            'Name' => Yii::t('app', 'Name'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemesters()
    {
        return $this->hasMany(Semester::className(), ['SeasonId' => 'SeasonId']);
    }

    /**
     * @inheritdoc
     * @return SeasonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeasonQuery(get_called_class());
    }
}
