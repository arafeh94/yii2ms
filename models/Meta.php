<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "meta".
 *
 * @property int $id
 * @property string $table_ref
 * @property string $field_name
 * @property string $field_type
 */
class Meta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_ref', 'field_name', 'field_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'table_ref' => Yii::t('app', 'Table Ref'),
            'field_name' => Yii::t('app', 'Field Name'),
            'field_type' => Yii::t('app', 'Field Type'),
        ];
    }

    /**
     * @inheritdoc
     * @return MetaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MetaQuery(get_called_class());
    }
}
