<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Major]].
 *
 * @see Major
 */
class MajorQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[IsDeleted]]=0');
    }

    /**
     * @inheritdoc
     * @return Major[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Major|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
