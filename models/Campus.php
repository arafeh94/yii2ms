<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "campus".
 *
 * @property int $CampusId
 * @property string $Name
 * @property bool $IsDeleted
 */
class Campus extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name'], 'required'],
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
            'CampusId' => Yii::t('app', 'Campus'),
            'Name' => Yii::t('app', 'Name'),
            'IsDeleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    /**
     * @inheritdoc
     * @return CampusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CampusQuery(get_called_class());
    }
}
