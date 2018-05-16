<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Campus]].
 *
 * @see Campus
 */
class CampusQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('[[IsDeleted]]=0');
    }

    /**
     * @inheritdoc
     * @return Campus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Campus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
